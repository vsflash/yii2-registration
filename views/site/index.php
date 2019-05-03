<?php

use buttflattery\formwizard\FormWizard;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

echo FormWizard::widget([
    'enablePersistence' => true,
//    'showStepURLhash' => true,
    'formOptions'=>[
        'id'=>'my_form_ajax',
        'enableClientValidation'=>false,
        'enableAjaxValidation'=>true,
    ],
    'steps'=>[
        [
           'model'=>$model_client,
            'title'=>'Step 1',
            'description'=>'Add your profile',
            'formInfoText'=> false,
            'fieldConfig' => [
                'only'=>[
                    'first_name',
                    'last_name',
                    'phone',
                ],
                'phone' => [
                    'widget' => \yii\widgets\MaskedInput::class,
//                    'persistenceEvents' => [
//                        'afterRestore' => 'function(event,params){
//
//                        }'
//                    ],
                    'options' => [
                        'options' => [
                            'placeholder' => 'Select a Phone Number',
                            'class' => 'form-control'
                        ],
                        'mask' => '+38 (099) 999-99-99',
                    ],
                ]
            ],
        ],
        [
            'model'=> $model_client,
            'title'=>'Step 2',
            'description'=>'Add your address',
            'formInfoText'=> false,
            'fieldConfig'=>[
                'only'=>[
                    'comment',
                ],
                'comment' => [
                    'options' => [
                        'placeholder' => 'Add comment',
//                        'type' => 'text',
                        'class' => 'form-control',
                        'cols' => 25,
                        'rows' => 10
                    ]
                ],
            ],
        ],
        [
            'model'=> $model_address,
            'title'=>'Step 3',
            'description'=>'Add your comment',
            'formInfoText' => false,
            'fieldConfig' => [
                'only'=>[
                    'city',
                    'street',
                    'number',
                ],
            ]
        ]
    ]
]);

 if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <h4><i class="icon fa fa-check"></i>Saved!</h4>
         <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <h4><i class="icon fa fa-check"></i>Saved!</h4>
         <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>
