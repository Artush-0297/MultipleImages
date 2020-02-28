<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class IndexController extends Controller
{
    public function index(){
        return view('index');
    }

    public function insertImages(Request $request) {
        try {
            $data = [];
            $files = $request->all();

            if (!is_array($files)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No files'
                ]);
            }

            foreach ($files as $file) {
                $receiver = new FileReceiver($file, $request, HandlerFactory::classFromRequest($request));

                if ($receiver->isUploaded()) {
                    $this->saveFile($receiver->receive()->getFile());
                    continue;
                }

                $save = $receiver->receive();

                if ($save->isFinished()) {
                    $data[] = $this->saveFile($save->getFile());
                }
                else {
                    $handler = $save->handler();
                    $data[] = [
                        "progress" => $handler->getPercentageDone(),
                        "finished" => false
                    ];
                }
            }

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    protected function saveFile($file)
    {
        $path = time() . $file->getClientOriginalName();
        $file->move(public_path('uploads'),$path);
        Media::query()->create(['path' => $path]);
    }
}
