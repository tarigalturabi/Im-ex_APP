<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use App\User;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Exception;

class HomeController extends Controller
{
    //
    public function generateDocx(){
        $phpword = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpword->addSection();
       // $section->addImage("https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/2560px-PHP-logo.svg.png");
       $section->addHeader();
       $section->addListItem("Hello");       
       $section->addTable();
        $section->addText("this is my first word document , with laravel");
        
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpword, 'Word2007');
        try{
            $objWriter->save(storage_path('helloWorld.docx'));

        }catch(Exception $e){return $e->getMessage();}
        //response()->download(storage_path('helloWorld.docx'));
    }

    public function wordExport($id)
    {
        $user = ModelsUser::findOrFail($id);
        $templateProcessor = new TemplateProcessor('word-template/user.docx');
        $templateProcessor->setValue('id', $user->id);
        $templateProcessor->setValue('name', $user->name);
        $templateProcessor->setValue('email', $user->email);
        $templateProcessor->setValue('address', $user->address);
        $fileName = $user->name;
        $templateProcessor->saveAs($fileName . '.docx');
        return response()->download($fileName . '.docx')->deleteFileAfterSend(true);
    }
}
