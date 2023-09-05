<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ModelFactoryInterface;
use App\Models\Image;
use App\Models\RoleList;
use App\Repositories\AdminRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class BaseModelController extends Controller
{
    protected $table;
    protected $modelFactory;
    protected $adminRepository;
    protected $paginate = 10;
    public function __construct(string $table)
    {
        $this->table = $table;
        $this->modelFactory = app(ModelFactoryInterface::class);
        $this->adminRepository = new AdminRepository($this->modelFactory, $this->table);;
    }

    protected function getModel()
    {
        $model = $this->modelFactory->createModel($this->table);
        $model = $this->applyTableConditions($model);
        return $model;
    }
    
    protected function applyTableConditions($model)
    {
        $table = $this->table;
        $userIdHasRole = RoleList::select('staff_id')->get();
        if ($table === 'customer') {
            $model = $model->whereNotIn('users.id', $userIdHasRole);
        } elseif ($table === 'staff') {
            $model = $model->whereIn('users.id', $userIdHasRole);
        }
        return $model;
    }

    //upload Image
    public function uploadImage($image)
    {
        $fileName = self::generateFileName($image);
        $image->move(public_path('media'), $fileName);
        $url = asset('media/' . $fileName);
        $image = Image::create([
            'url' => $url
        ]);
        return $image->id;
    }
    public static function generateFileName($file)
    {
        $originName = $file->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        return $fileName . '_' . time() . '.' . $extension;
    }

    // this function has use for paymentController by Pos 
    protected function getCustomer(string $phone){
        $customers = $this->adminRepository->findCustomerByPhone($phone);
        if($customers){
            return response()->json([
                'is_user'=>true,
                'customers'=>$customers
            ]);
        }else{
            return response()->json([
                'is_user'=>false,
                'phone'=>$phone
            ]);
        }
    }

    protected function getModelWithBaseModelController(string $table){
        return new BaseModelController($table);
    }
}
