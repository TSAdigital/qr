<?php

namespace app\controllers;

use app\models\Link;
use app\models\Stats;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
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
     * @return false|string
     * @throws Exception
     */
    public function actionIndex()
    {
        $model = new Link();

        if ($this->request->isPost) {
            $model->short_link = uniqid();
            if ($model->load($this->request->post())) {
                if ($model->save()) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return json_encode(['link' => Yii::$app->urlManager->createAbsoluteUrl(['site/get-link', 'id' => $model->short_link])]);
                }
                return json_encode(['errors' => 'Произошла ошибка при генерации ссылки.']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('index', ['model' => $model]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @param $id
     * @return void
     * @throws Exception
     * @throws HttpException
     */
    public function actionGetLink($id)
    {
        $model = Link::findOne(['short_link' => $id]);

        if ($model) {
            $stats = new Stats();
            $stats->link_id = $model->id;
            $stats->ip_address = Yii::$app->request->userIP;
            $stats->save();
            $this->redirect($model->link);
        } else {
            throw new HttpException(404, 'Запрошенная ссылка не найдена');
        }
    }
}
