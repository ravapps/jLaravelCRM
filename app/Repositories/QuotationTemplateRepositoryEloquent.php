<?php namespace App\Repositories;


use App\Models\Qtemplate;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class QuotationTemplateRepositoryEloquent extends BaseRepository implements QuotationTemplateRepository
{
    private $userRepository;

    public function model()
    {
        return Qtemplate::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function generateParams(){
        $this->userRepository = new UserRepositoryEloquent(app());
    }


    public function getAll()
    {
        $models = $this->model;
        return $models;
    }
    public function createQtemplate(array $data)
    {
        $this->generateParams();
        $user = $this->userRepository->getUser();

        $data['user_id']= $user->id;
        $team = collect($data)->except('product_list','taxes','product_id','product_name','description','quantity','price','sub_total','sproduct_list','staxes','scharge','sproduct_id','sdescription','squantity','sprice','ssub_total')->toArray();
        $qtemplate = $this->create($team);
        $list =[];

        foreach ($data['product_id']as $key =>$product){
            if ($product != "") {
                $temp['quantity'] = $data['quantity'][$key];
                $temp['dayperiod'] = 0;
                $temp['price'] = $data['price'][$key];
                $list[$data['product_id'][$key]] = $temp;
            }
        }
        $temp = [];
        if(isset($data['sproduct_id']))
        foreach ($data['sproduct_id']as $key =>$product){
            if ($product != "") {
                $temp['quantity'] = $data['squantity'][$key];
                $temp['dayperiod'] = $data['scharge'][$key];
                $temp['price'] = $data['sprice'][$key];
                $list[$data['sproduct_id'][$key]] = $temp;
            }
        }
        $qtemplate->qTemplateProducts()->attach($list);
    }

    public function updateQtemplate(array $data,$qtemplate_id)
    {
        $this->generateParams();
        $team = collect($data)->except('product_list','taxes','product_id','product_name','description','quantity','price','sub_total','sproduct_list','staxes','scharge','sproduct_id','sdescription','squantity','sprice','ssub_total')->toArray();
        $qtemplate = $this->update($team,$qtemplate_id);
        $list =[];

        if(isset($data['product_id']))
        foreach ($data['product_id']as $key =>$product){
            if ($product != "") {
                $temp['quantity'] = $data['quantity'][$key];
                $temp['dayperiod'] = 0;
                $temp['price'] = $data['price'][$key];
                $list[$data['product_id'][$key]] = $temp;
            }
        }
        $temp = [];
        if(isset($data['sproduct_id']))
        foreach ($data['sproduct_id']as $key =>$product){
            if ($product != "") {
                $temp['quantity'] = $data['squantity'][$key];
                $temp['dayperiod'] = $data['scharge'][$key];
                $temp['price'] = $data['sprice'][$key];
                $list[$data['sproduct_id'][$key]] = $temp;
            }
        }


        $qtemplate->qTemplateProducts()->sync($list);
    }

    public function deleteQtemplate($deleteQtemplate)
    {
        $this->generateParams();
//        Remove qtemplate products
        $qtemplateProduct = $this->find($deleteQtemplate);
        $qtemplateProduct->qTemplateProducts()->detach();
        $this->delete($deleteQtemplate);
    }
}
