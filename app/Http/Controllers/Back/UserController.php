<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Exports\UsersExport;
use App\Http\Resources\Datatable\User\UserCollection;
use App\Models\Role;
use App\Rules\NotSpecialChar;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        return view('back.users.index');
    }

    public function apiIndex(Request $request)
    {
        $this->authorize('users.index');

        $users = User::filter($request);

        $users = datatable($request, $users);

        return new UserCollection($users);
    }

    public function create()
    {
        $roles = Role::latest()->get();
        $categories = Category::query()->select(['id', 'title'])->get();
        $products = Product::query()->select(['id', 'title'])->get();

        return view('back.users.create', compact('roles', 'categories', 'products'));
    }

    public function edit(User $user)
    {
        $roles = Role::latest()->get();
        $categories = Category::query()->select(['id', 'title'])->get();
        $products = Product::query()->select(['id', 'title'])->get();

        return view('back.users.edit', compact('user', 'roles', 'categories', 'products'));
    }

    public function store(Request $request)
    {
		$request->merge(['username'=>$request->filled('username') ? "0".substr($request->username,-10) : null ]);
        $rules = [
            'first_name' => ['required', 'string', 'max:255', new NotSpecialChar()],
            'last_name' => ['required', 'string', 'max:255', new NotSpecialChar()],
            'level' => 'in:user,admin',
            'username' => ['required', 'string','regex:/^(?:98|\+98|0098|0)?9[0-9]{9}$/', 'unique:users'],
            'email' => ['string', 'email', 'max:255', 'unique:users', 'nullable'],
            'password' => ['required', 'string', 'confirmed:confirmed'],
            'referral_code' => ['nullable', 'string', 'unique:users,referral_code'],
            'referral_percentage' => ['nullable', 'numeric', 'between:0,100'],
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ];
        if (auth()->user()->can('marketer')) {
            $rules['referral_code'] = ['nullable', 'string', 'unique:users,referral_code'];
            $rules['referral_percentage'] = ['nullable', 'numeric', 'between:0,100'];
            $rules['referral_categories'] = ['nullable', 'array'];
            $rules['referral_categories.*'] = ['required', 'array:value,title'];
            $rules['referral_categories.*.value'] = ['required', 'numeric', 'between:1,100'];
            $rules['referral_categories.*.title'] = ['required', 'exists:categories,title'];
            $rules['referral_products'] = ['nullable', 'array'];
            $rules['referral_products.*'] = ['required', 'array:value,title'];
            $rules['referral_products.*.value'] = ['required', 'numeric', 'between:1,100'];
            $rules['referral_products.*.title'] = ['required', 'exists:products,title'];
        }
        $this->validate($request, $rules,[],array_merge(collect($request->referral_categories)->mapWithKeys(function ($item, $key) {
            return [
                "referral_categories." . $key => optional($item)->offsetGet('title'),
                "referral_categories." . $key . ".value" => "مقدار",
                "referral_categories." . $key . ".title" => "عنوان",
            ];
        })->toArray(), collect($request->referral_products)->mapWithKeys(function ($item, $key) {
            return [
                "referral_products." . $key => optional($item)->offsetGet('title'),
                "referral_products." . $key . ".value" => "مقدار",
                "referral_products." . $key . ".title" => "عنوان",
            ];
        })->toArray()));
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'level' => $request->level,
            'password' => Hash::make($request->password),
            'verified_at' => $request->verified_at ? Carbon::now() : null,
        ];
        if (auth()->user()->can('marketer')) {
            $data['referral_code'] = $request->referral_code;
            $data['referral_percentage'] = $request->filled('referral_percentage') ? $request->referral_percentage : 0;
        }
        $user = User::create($data);

        if ($request->filled('referral_categories')) {
            $user->referralCategories()->sync(collect($request->referral_categories)->filter(function ($item, $key) {
                return array_key_exists('value', $item) && strlen(trim($item['value']));
            })->mapWithKeys(function ($item, $key) {
                return [$key => ['percentage' => $item['value']]];
            })->toArray());
        }else{
            $user->referralCategories()->sync([]);
        }
        if ($request->filled('referral_products')) {
            $user->referralProducts()->sync(collect($request->referral_products)->filter(function ($item, $key) {
                return array_key_exists('value', $item) && strlen(trim($item['value']));
            })->mapWithKeys(function ($item, $key) {
                return [$key => ['percentage' => $item['value']]];
            })->toArray());
        }else{
            $user->referralProducts()->sync([]);
        }

        if ($request->hasFile('image')) {
            $file = $request->image;
            $name = uniqid() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $request->image->storeAs('users', $name);

            $user->image = '/uploads/users/' . $name;
            $user->save();
        }

        $user->roles()->attach($request->roles);

        toastr()->success('کاربر با موفقیت ایجاد شد.');

        return response('success');
    }

    public function update(User $user, Request $request)
    {
		$request->merge(['username'=>$request->filled('username') ? "0".substr($request->username,-10) : null ]);
        $rules = [
            'first_name' => ['required', 'string', 'max:255', new NotSpecialChar()],
            'last_name' => ['required', 'string', 'max:255', new NotSpecialChar()],
            'level' => 'in:user,admin',
            'username' => ['required', 'string','regex:/^(?:98|\+98|0098|0)?9[0-9]{9}$/', "unique:users,username,$user->id"],
            'email' => ['string', 'email', 'max:255', "unique:users,email,$user->id", 'nullable'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed:confirmed'],
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ];
        if (auth()->user()->can('marketer')) {
            $rules['referral_code'] = ['nullable', 'string', 'unique:users,referral_code,' . $user->id];
            $rules['referral_percentage'] = ['nullable', 'numeric', 'between:0,100'];
            $rules['referral_categories'] = ['nullable', 'array'];
            $rules['referral_categories.*'] = ['required', 'array:value,title'];
            $rules['referral_categories.*.value'] = ['required', 'numeric', 'between:1,100'];
            $rules['referral_categories.*.title'] = ['required', 'exists:categories,title'];
            $rules['referral_products'] = ['nullable', 'array'];
            $rules['referral_products.*'] = ['required', 'array:value,title'];
            $rules['referral_products.*.value'] = ['required', 'numeric', 'between:1,100'];
            $rules['referral_products.*.title'] = ['required', 'exists:products,title'];
        }
        $this->validate($request, $rules,[], array_merge(collect($request->referral_categories)->mapWithKeys(function ($item, $key) {
            return [
                "referral_categories." . $key => optional($item)->offsetGet('title'),
                "referral_categories." . $key . ".value" => "مقدار",
                "referral_categories." . $key . ".title" => "عنوان",
            ];
        })->toArray(), collect($request->referral_products)->mapWithKeys(function ($item, $key) {
            return [
                "referral_products." . $key => optional($item)->offsetGet('title'),
                "referral_products." . $key . ".value" => "مقدار",
                "referral_products." . $key . ".title" => "عنوان",
            ];
        })->toArray()));

        $verified_at = $user->verified_at ?: Carbon::now();

        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'level' => $request->level,
            'verified_at' => $request->verified_at ? $verified_at : null,
        ];
        if (auth()->user()->can('marketer')) {
            $data['referral_code'] = $request->referral_code;
            $data['referral_percentage'] = $request->filled('referral_percentage') ? $request->referral_percentage : 0;
        }
        $user->update($data);

        if ($request->filled('referral_categories')) {
            $user->referralCategories()->sync(collect($request->referral_categories)->filter(function ($item, $key) {
                return array_key_exists('value', $item) && strlen(trim($item['value']));
            })->mapWithKeys(function ($item, $key) {
                return [$key => ['percentage' => $item['value']]];
            })->toArray());
        }else{
            $user->referralCategories()->sync([]);
        }
        if ($request->filled('referral_products')) {
            $user->referralProducts()->sync(collect($request->referral_products)->filter(function ($item, $key) {
                return array_key_exists('value', $item) && strlen(trim($item['value']));
            })->mapWithKeys(function ($item, $key) {
                return [$key => ['percentage' => $item['value']]];
            })->toArray());
        }else{
            $user->referralProducts()->sync([]);
        }

        if ($request->password) {
            $password = Hash::make($request->password);

            $user->update([
                'password' => $password
            ]);

            DB::table('sessions')->where('user_id', $user->id)->delete();
        }

        if ($request->hasFile('image')) {
            $file = $request->image;
            $name = uniqid() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $request->image->storeAs('users', $name);

            $user->image = '/uploads/users/' . $name;
            $user->save();
        }

        $user->roles()->sync($request->roles);

        toastr()->success('کاربر با موفقیت ویرایش شد.');

        return response('success');
    }

    public function show(User $user)
    {
        return view('back.users.show', compact('user'));
    }

    public function destroy(User $user, $multiple = false)
    {
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        if (!$multiple) {
            toastr()->success('کاربر با موفقیت حذف شد.');
        }

        return response('success');
    }

    public function multipleDestroy(Request $request)
    {
        $this->authorize('users.delete');

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => [
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('id', '!=', auth()->user()->id)->where('level', '!=', 'creator');
                })
            ]
        ]);

        foreach ($request->ids as $id) {
            $user = User::find($id);
            $this->destroy($user, true);
        }

        return response('success');
    }

    public function export(Request $request)
    {
        $this->authorize('users.export');

        $users = User::where('level', '!=', 'creator')
            ->filter($request)
            ->get();

        switch ($request->export_type) {
            case 'excel':
            {
                return $this->exportExcel($users, $request);
                break;
            }
            default:
            {
                return $this->exportPrint($users, $request);
            }
        }
    }

    public function views(User $user)
    {
        $views = $user->views()->latest()->paginate(20);

        return view('back.users.views', compact('views', 'user'));
    }

    public function showProfile()
    {
        return view('back.users.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'username' => 'required|string|max:191',
        ]);

        if ($request->password || $request->password_confirmation) {
            $this->validate($request, [
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required',
            ]);

            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            $this->validate($request, [
                'image' => 'image|max:2048',
            ]);

            $imageName = time() . '_' . $user->id . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/users/'), $imageName);

            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }

            $user->image = '/uploads/users/' . $imageName;
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->bio = $request->bio;
        $user->save();

        if ($request->password) {
            DB::table('sessions')->where('user_id', auth()->user()->id)->delete();
        }


        $options = $request->only([
            'theme_color',
            'theme_font',
            'menu_type'
        ]);

        foreach ($options as $option => $value) {
            user_option_update($option, $value);
        }

        return response()->json('success');
    }

    private function exportExcel($users, Request $request)
    {
        return Excel::download(new UsersExport($users, $request), 'users.xlsx');
    }

    private function exportPrint($users, Request $request)
    {
        //
    }
}
