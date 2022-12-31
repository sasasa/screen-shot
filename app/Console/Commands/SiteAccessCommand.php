<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\LinkPreview\LinkPreviewInterface;
use App\Lib\LinkPreview\LinkPreviewRuntimeException;
use App\Models\Site;
use Exception;
use App\Usecases\SiteUpdateWithTags;

class SiteAccessCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:access';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SiteAccess Command';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(LinkPreviewInterface $linkPreview, SiteUpdateWithTags $usecase)
    {
        $this->line("start site:access");
        Site::query()->whereNull('mode_color')->each(function($site) use($linkPreview, $usecase){
            try {
                $response = $linkPreview->get($site->url);
                $s = $usecase($response);
                $this->info("save: ". $s->url);
                sleep(5);
            } catch (LinkPreviewRuntimeException $e) {
                // dd($e);
                $this->error('LinkPreviewRuntimeException');
                $this->error($e->getMessage());
                sleep(5);
                // return Command::FAILURE;
            } catch (Exception $e) {
                // dd($e);
                $this->error('Exception');
                $this->error($e->getMessage());
                sleep(5);
                // return Command::FAILURE;
            }
        });
        $this->line("end site:access");
        return Command::SUCCESS;
    }
}
