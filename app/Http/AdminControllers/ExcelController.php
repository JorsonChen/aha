<?php

namespace App\Http\AdminControllers;

use App\Http\AdminControllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Excel;

class ExcelController extends Controller
{
    //Excel文件导出功能 
    /*public function export(){
        $cellData = [
            ['学号','姓名','成绩'],
            ['10001','AAAAA','99'],
            ['10002','BBBBB','92'],
            ['10003','CCCCC','95'],
            ['10004','DDDDD','89'],
            ['10005','EEEEE','96'],
        ];
        Excel::create('score',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }*/

    //Excel文件导出功能,并存储在服务器上(storage/export) 
    /*public function export(){
        $cellData = [
            ['学号','姓名','成绩'],
            ['10001','AAAAA','99'],
            ['10002','BBBBB','92'],
            ['10003','CCCCC','95'],
            ['10004','DDDDD','89'],
            ['10005','EEEEE','96'],
        ];
        Excel::create('学生成绩',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->store('xls')->export('xls');
    }*/

    /**
     *Excel导出功能
     *
     *@return void
     */
    public function export(){
        $articles = (Article::orderBy('id', 'desc')->paginate(10))->toArray();
        $cellData = $articles['data'];
        dd($cellData);exit;

        Excel::create('score',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->store('xls')->export('xls');
    }

    /**
     *Excel导入功能
     *
     *@return void
     */
    public function import(){
        $filePath = 'storage/exports/'.iconv('UTF-8', 'GBK', 'score').'.xls';
        Excel::load($filePath, function($reader) {
            /*$data = $reader->all();
            dd($data);*/

            $reader = $reader->getSheet(0);
            //获取表中的数据
            $results = $reader->toArray();
            dd($results);
        });
    }
}
