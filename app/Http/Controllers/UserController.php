<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Queue;
class UserController extends Controller
{
    public function index()
     {
        $users = ModelsUser::all();
        return view('users.index', compact('users'));
     }

    public function show($id)
     {
        $user = ModelsUser::findOrFail($id);
        return view('users.show', compact('user'));
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

    public function pdfExport($id){
        //$users = ModelsUser::get();
        $users[] = ModelsUser::find($id);
    
         // return $users;
        $data = [
            'title' => 'Welcome to LaravelTuts.com',
            'date' => date('m/d/Y'),
            'users' => $users
        ]; 
            
        $pdf = PDF::loadView('myPDF', $data);
     
        return $pdf->download('laraveltuts.pdf');
     }

    public function ExcelImport(Request $request){
        $file = $request->file('file');
        Excel::import(new UsersImport, $file);
        //for large data
        //Queue::push(new UsersImport($file));
        return "success";
        return redirect()->back()->with('success', 'Data imported successfully!');
     }

    public function ExcelExport(){
        return Excel::download(new UsersExport, 'users.xlsx');        
        //return redirect()->back()->with('success', 'Data imported successfully!');
     }
}