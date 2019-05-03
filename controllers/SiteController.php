<?php

namespace app\controllers;

use app\models\Client;
use app\models\ClientAddress;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isPost) {
            $this->registration(Yii::$app->request->post());
        }

        $model_client = new Client();
        $model_address = new ClientAddress();
        return $this->render('index', [
            'model_address' => $model_address,
            'model_client' => $model_client,
        ]);
    }

    /**
     * Registration client
     * @throws \yii\base\Exception
     */
    protected function registration() {
        $client = new Client();

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $client->load(Yii::$app->request->post());
            return ActiveForm::validate($client);
        }

        if ($client->load(Yii::$app->request->post()) && $client->save()) {
            $client->token = Yii::$app->security->generateRandomString();
            $client->save();

            $model_address = new ClientAddress();
            $model_address->load(Yii::$app->request->post());
            $model_address->client_id = $client->id;
            $model_address->save();
            Yii::$app->session->setFlash('success', "Registration successfully. Your token: " . $client->token);
        } else {
            Yii::$app->session->setFlash('error', "Client not saved.");
        }
    }
}
