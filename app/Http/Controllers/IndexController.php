<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\ContentRangeUploadHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class IndexController extends Controller
{
    public function index(){
        return view('index');
    }

    public function insertImages(Request $request) {
        $data = [];

        $files = $request->allFiles();

        if (!is_array($files)) {
            return response()->json([
                'success' => false,
                'message' => 'No files'
            ]);
        }

        foreach ($files as $file) {
            //Вместо того, чтобы передавать имя индекса, передайте объект UploadFile из массива $ files, который мы зацикливаем
            //Исключение выдается, если загрузка файла недопустима (ограничение размера и т. Д.)

            //Создать приемник файлов через динамический обработчик
            $receiver = new FileReceiver($file, $request, HandlerFactory::classFromRequest($request));

            if ($receiver->isUploaded()) {
                continue;
            }

            //получить файл
            $save = $receiver->receive();

            // проверить, завершена ли загрузка (в режиме чанков он будет отправлять файлы меньшего размера)
            if ($save->isFinished()) {
                // сохраните файл и верните любой нужный вам ответ
                $files[] = $this->saveFile($save->getFile());
            } else {
                // мы находимся в режиме чанка, давайте отправим текущий прогресс

                $handler = $save->handler();

                // Добавить готовый файл
                $data[] = [
                    "progress" => $handler->getPercentageDone(),
                    "finished" => false
                ];
            }
        }

        dd($data);
//        return response()->json([
//            'success' => true
//        ]);
    }

    protected function saveFileToS3($file)
    {
        $fileName = $this->createFilename($file);

        $disk = Storage::disk('s3');
        // It's better to use streaming Streaming (laravel 5.4+)
        $disk->putFileAs('photos', $file, $fileName);

        // for older laravel
        // $disk->put($fileName, file_get_contents($file), 'public');
        $mime = str_replace('/', '-', $file->getMimeType());

        // We need to delete the file when uploaded to s3
        unlink($file->getPathname());

        return response()->json([
            'path' => $disk->url($fileName),
            'name' => $fileName,
            'mime_type' =>$mime
        ]);
    }

    protected function saveFile(UploadedFile $file)
    {
        $fileName = $this->createFilename($file);
        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());
        // Group files by the date (week
        $dateFolder = date("Y-m-W");

        // Build the file path
        $filePath = "upload/{$mime}/{$dateFolder}/";
        $finalPath = storage_path("app/".$filePath);

        // move the file name
        $file->move($finalPath, $fileName);

        return response()->json([
            'path' => $filePath,
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }

    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension

        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;

        return $filename;
    }
}
