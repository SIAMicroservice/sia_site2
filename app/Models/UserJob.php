<?php

    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class UserJob extends Model{
        protected $table = 'tbluserjob';
        protected $fillable = [
            'jobname'
        ];

        public $timestamps = false;
        protected $primaryKey = 'jobid';
    }

