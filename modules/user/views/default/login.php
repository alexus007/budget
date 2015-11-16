<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

$this->title = 'Семейный бюджет';
?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
    <h1><?=$this->title;?></h1>
        <p>- это<br>
        <ul>
            <li>Ведение бюджета в различных валютах ($ + Рубли). Форма заведения затрат и поступлений в бюджет (включая дату затраты/поступления).</li>
            <li>Возможность изменения статей бюджета (добавление, изменение статьи бюджета). Например: статьи бюджета – расходы на автомобиль, расходы на питание, расходы на досуг, доход – заработная плата.</li>
            <li>Возможность получения сводного отчета за заданный период времени. В разрезе – сколько расходов/доходов и по каким статьям было за заданный период времени, вывод суммарных дохода и расхода за этот период времени.</li>
        </ul>
        </p>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <div class="panel panel-default">
            <div class="panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                    <?= $form->field($model, 'username') ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Вход', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                    </div>
                    <div>
                        <?= Html::a('Забыли пароль?', ['password-reset-request']) ?>
                        <span>|</span>
                        <?= Html::a('Регистрация', ['signup']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
            </div>
        </div>
        </div>
    </div>

