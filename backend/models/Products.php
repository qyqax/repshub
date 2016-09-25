<?php

namespace backend\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "products".
 *
 * @property string $product_id
 * @property string $product_code
 * @property string $product_name
 * @property double $product_price
 * @property integer $discount
 * @property string $category_id
 * @property string $product_image
 * @property integer $expiry_date
 * @property integer $send_alert
 * @property string $created_at
 * @property string $updated_at
 *
 * @property OffersProduct[] $offersProducts
 * @property ProductSubcategory[] $productSubcategories
 * @property Categories[] $categories
 * @property Categories $category
 * @property PurchaseProduct[] $purchaseProducts
 * @property Purchases[] $purchases
 */
class Products extends \yii\db\ActiveRecord
{

    public $product_new_image; 
    public $subcategories = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'product_code', 'product_name', 'product_price', 'category_id','company_id',  'created_at'], 'required'],
            [['product_price'], 'number','min'=>0.01],
            
           // [['subcategories'],'required' , 'message' => 'Choose subcategory.'],
           // [['subcategories'],'safe'],
            [[ 'expiry_date'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['product_id', 'category_id','company_id'], 'string', 'max' => 50],
            [['product_code', 'product_name'], 'string', 'max' => 150],
            [['product_image'], 'file', 'extensions'=>'jpg, gif, png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'Product'),
            'product_code' => Yii::t('app', 'Product Code'),
            'product_name' => Yii::t('app', 'Product Name'),
            'product_price' => Yii::t('app', 'Product Price'),
            
            'category_id' => Yii::t('app', 'Main Category'),
            'product_image' => Yii::t('app', 'Product Image'),
            'expiry_date' => Yii::t('app', 'Product Expire After (in days)'),
          
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffersProducts()
    {
        return $this->hasMany(OffersProduct::className(), ['product_id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getProductSubcategories()
    {
        return $this->hasMany(ProductSubcategory::className(), ['product_id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['category_id' => 'category_id'])->viaTable('product_subcategory', ['product_id' => 'product_id']);
    }
    public function getSubCategories()
    {
        $subcategories = $this->hasMany(Categories::className(), ['category_id' => 'category_id'])->viaTable('product_subcategory', ['product_id' => 'product_id'])->all();
        $output = '';
        foreach ($subcategories as $subcategory) {
            if($subcategory === end($subcategories))
            {
              $output = $output.$subcategory->category_name;
            }
            else
            {
                $output = $output.$subcategory->category_name.","; 
            }
        }
       // var_dump($output);die;
        return $output;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::className(), ['product_id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchases()
    {
        return $this->hasMany(Purchases::className(), ['purchase_id' => 'purchase_id'])
        ->viaTable('purchase_product', ['product_id' => 'product_id']);
    }

   


    public function getdropCategories()
    {
        $data = Categories::find()->asArray()->where(['not',['parent_id'=> NULL]])->all();
        return ArrayHelper::map($data,'category_id','category_name');
    }

  
    public static function getProductPrice($id)
    {
     $price = Products::find()->where(['product_id'=>$id])->one();
     
     return $price->product_price;
    }


    public function getPhoto()
    {
      return($this->product_image == '' || !isset($this->product_image)) ? 'default-product.jpg' : $this->product_image;
    }

    public function getCompany()
    {
        return $this->hasOne(Companies::className(), ['id' => 'company_id']);
    }

    public function getItemsSold()
    {
        $command = Yii::$app->db->createCommand("
            SELECT sum(pp.quantity) FROM purchase_product pp 
            join purchases p on pp.purchase_id = p.purchase_id 
            join purchase_statuses ps on p.purchase_id = ps.purchase_id 
            where pp.product_id ='".$this->product_id."' and ps.status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
               and ps.status = 'delivery' ");
        
        if($command->queryScalar()==NULL){
            return 0;
        }else{
          return $command->queryScalar();  
        }
    }

  
   
   }
