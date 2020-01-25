<?php


namespace common\models;


use commom\models\TaskAttachments;
use yii\base\Model;
use yii\imagine\Image;
use yii\web\UploadedFile;

class TaskAttachmentsAddForm extends Model
{
    public $task_id;
    /** @var  UploadedFile */
    public $attachment;


    protected $originalDir = '@img/task/';
    protected $copiesDir = '@img/task/small/';

    protected $filepath;
    protected $filename;

    public function rules()
    {
        return [
            [['task_id', 'attachment'], 'required'],
            [['task_id'], 'integer'],
            [['attachment'], 'file', 'extensions' => 'jpg, png']
        ];
    }

    public function save()
    {
        if($this->validate()){
            $this->saveUploadedFile();
            $this->createMinCopy();
            return $this->saveData();
        }
        return false;
    }

    private function saveUploadedFile(){
        $randomString = \Yii::$app->security->generateRandomString();
        $this->filename = $randomString . "." . $this->attachment->getExtension();
        $this->filepath = \Yii::getAlias("{$this->originalDir}{$this->filename}");
        $this->attachment->saveAs($this->filepath);
    }

    private function createMinCopy(){
        Image::thumbnail($this->filepath, 100, 100)
            ->save(\Yii::getAlias("{$this->copiesDir}{$this->filename}"));
    }

    private function saveData(){
        $model = new \common\models\TaskAttachments([
            'task_id' => $this->task_id,
            'path' => $this->filename
        ]);
        return $model->save();
    }
}