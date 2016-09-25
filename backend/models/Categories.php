<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property string $category_id
 * @property string $category_name
 * @property string $parent_id
 *
 * @property Categories $parent
 * @property Categories[] $categories
 * @property Products[] $products
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'category_name'], 'required'],
            [['category_id', 'parent_id','company_id'], 'string', 'max' => 50],
            [['category_id','parent_id','company_id'],'safe'],
            [['category_name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => Yii::t('app', 'Category ID'),
            'category_name' => Yii::t('app', 'Category Name'),
            'parent_id' => Yii::t('app', 'Parent ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Categories::className(), ['category_id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['parent_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['category_id' => 'category_id']);
    }
    public function getSubcategoryProducts()
    {
        return $this->hasMany(Products::className(),['product_id'=>'product_id'])
        ->viaTable('product_subcategory',['category_id'=>'category_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Companies::className(), ['id' => 'company_id']);
    }


}
