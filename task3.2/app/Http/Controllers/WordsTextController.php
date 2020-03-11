<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\TextRequest;
use App\Uploaded_text;
use App\Word;
use Illuminate\Http\Request;

class WordsTextController extends Controller
{
    public function index (){
        $arrListText =Uploaded_text::where('id', '>', 1)->orderBy('id','desc')->paginate(6);
        return view('uploaded_text',compact('arrListText'));
    }

    public function oneText($id){
        $arr_count = Uploaded_text::join('word', 'uploaded_text.id', '=', 'word.text_id')
            ->where('text_id', '=', (int)$id)
            ->get();
        //dd($arr_count);
        return view('onetextpage',compact('arr_count'));
    }

    public function addText(){

        return view('addtext');
    }

    public function addWords(TextRequest $request){

        if (isset($request-> content))
        {
            $this->storeRecord($request->content);
        }

        if ($request->hasFile('exampleFile'))
        {
            $this->storeRecord($this->processFile($request->file('exampleFile')));
        }
        return redirect(route('index'));
    }

    public function storeRecord($content){
        $recText = new Uploaded_text();
        $recText->countWords($content);
        $recText -> content = $content;
        //dd($rec->arr_count);
        //dd($rec->arr_count);
        $recText->words_count = array_sum($recText->arr_count);
        $recText->save();

        $text_id = $recText->id;
        //dd ($text_id);
        foreach ($recText->arr_count as $key => $value) {
            $recWord = new Word();
            $recWord->text_id = $text_id;
            $recWord->word = $key;
            $recWord->count = $value;
            //$recWord->save(['text_id' => $text_id, 'word' => $key, 'count' => $value]);
            $recWord->save();
        }
    }

    public  function processFile($data)
    {
        $strFile = '';
        $strErr = '';
        $fileTmp = $data->path();
        //$fileSize = $data->getSize();
        //$errFile = $data->error();

        //$fileType = $data->getMimeType();

        //$maxfileSize = 30000;


        // Проверяем, принят ли файл
        if (is_uploaded_file($fileTmp)) {

// Проверяем, является ли файл текстом  не пустой ли, не слишком большой;
//            if (($fileType == 'text/plain') && ($fileSize > 0 && $fileSize <= $maxfileSize)) {
                $strFile = trim(htmlentities(strip_tags(file_get_contents($fileTmp))));
                unlink($fileTmp);
 //           } else {
 //               $strErr = 'Попытка добавить файл недопустимого формата и размера!';
 //               unlink($fileTmp);
 //           }
        } else {
            $strErr = "Ошибка закачки # $errFile!";
        }

        return $strFile;
    }




}
