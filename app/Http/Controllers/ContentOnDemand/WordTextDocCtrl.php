<?php

namespace App\Http\Controllers\ContentOnDemand;

use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\NewContentEdits;
use App\Models\NewContentTask;
use Illuminate\Http\Request;

class WordTextDocCtrl extends Controller
{
  
    /**
     * To create the Docs file from php code
     *
     */
    public function exportDocsFile($id)
    {
        // $userId =  TrackSession::get()->userId();
        $title = NewContentEdits::where('new_content_id',$id)->first();
       $f = $title->contentTask->title;
        $filename = "$f.doc";
        header("Content-Type: application/force-download");   //it will download the file without open it in browser
        header("Content-Disposition: attachment; filename=" . basename($filename));
        header("Content-Description: File Transfer");
        @readfile($filename);
        $content = NewContentEdits::where('new_content_id', $id)
            ->first();
        
            $new = html_entity_decode($content->content);
        
         $docsBody = '<html>
                      <head></head>
                      <body>
                    <section class="content">
                            <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">


                                <!-- remark form -->
                                <div class="card collapsed-card">
                                    
                                    <!-- /.card-header -->
                                    <div class="card-body">
                            

                                    </div>

                                    <div class="card-footer"></div>

                                </div>
                                <!-- end remark form -->

                                <div class="card">
                                    <div class="card-header">
                                    <div class="row">
                    
                                    </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                    <div id="content-preview">
                                    '.$new.'
                                    </div>
                                    </div>

                                    <div class="card-footer"></div>

                                </div>

                                </div>

                            </div>

                            </div>

                        </section>
                      </body>
                      </html>';

    
        echo $docsBody;
    }
}
