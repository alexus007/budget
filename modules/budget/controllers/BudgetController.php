<?php

namespace app\modules\budget\controllers;

use app\models\Budget;
use app\models\BudgetHistory;
use app\models\BudgetItem;
use app\models\query\BudgetHistorySearch;
use app\models\query\BudgetSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use Yii;

/**
 * BudgetController implements the CRUD actions for Budget model.
 */
class BudgetController extends Controller
{
	/**
	 * @var boolean whether to enable CSRF validation for the actions in this controller.
	 * CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
	 */
	public $enableCsrfValidation = false;

	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	/**
	 * Lists all Budget models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel  = new BudgetSearch;
		$dataProvider = $searchModel->search($_GET);
		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);
	}

	/**
	 * Displays a single Budget model.
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionView($id)
	{

		$modelHistory = new BudgetHistory;
		$historySearch = new BudgetHistorySearch;
		$providerIncome = $historySearch->searchItems($id, BudgetItem::TYPE_INCOME, Yii::$app->request->queryParams);
		$providerCost = $historySearch->searchItems($id, BudgetItem::TYPE_COST, Yii::$app->request->queryParams);
		\Yii::$app->session['__crudReturnUrl'] = Url::previous();
		Url::remember();
		Tabs::rememberActiveState();
		try {
			if ($modelHistory->load($_POST) && $modelHistory->save()) {
				return $this->redirect(Url::previous());
			} elseif (!\Yii::$app->request->isPost) {
				$modelHistory->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$modelHistory->addError('_exception', $msg);
		}

		return $this->render('view', [
			'model' => $this->findModel($id),
			'modelHistory' => $modelHistory,
			'providerIncome' => $providerIncome,
			'providerCost' => $providerCost,
		]);
	}

	/**
	 * Creates a new Budget model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Budget;

		try {
			if ($model->load($_POST) && $model->save()) {
				return $this->redirect(Url::previous());
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}
		return $this->render('create', ['model' => $model]);
	}

	/**
	 * Updates an existing Budget model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(Url::previous());
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Budget model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		try {
			$this->findModel($id)->delete();
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			\Yii::$app->getSession()->setFlash('error', $msg);
			return $this->redirect(Url::previous());
		}

		// TODO: improve detection
		$isPivot = strstr('$id',',');
		if ($isPivot == true) {
			return $this->redirect(Url::previous());
		} elseif (isset(\Yii::$app->session['__crudReturnUrl']) && \Yii::$app->session['__crudReturnUrl'] != '/') {
			Url::remember(null);
			$url = \Yii::$app->session['__crudReturnUrl'];
			\Yii::$app->session['__crudReturnUrl'] = null;

			return $this->redirect($url);
		} else {
			return $this->redirect(['index']);
		}
	}

	public function actionDeleteHistory($id)
	{
        if (($model = BudgetHistory::findOne($id)) !== null) {
            try {
                $model->delete();
                return $this->redirect(Url::previous());
            } catch (\Exception $e) {
                $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
                \Yii::$app->getSession()->setFlash('error', $msg);
                return $this->redirect(Url::previous());
            }
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }

	}

	/**
	 * Finds the Budget model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Budget the loaded model
	 * @throws HttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Budget::findOne($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}
}
