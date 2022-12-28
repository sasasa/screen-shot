<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\LinkPreview\LinkPreviewInterface;
use App\Lib\LinkPreview\LinkPreviewRuntimeException;
use App\Models\Site;
use Exception;

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
    public function handle(LinkPreviewInterface $linkPreview)
    {
        $this->line("start site:access");
        try {
            Site::query()->whereNull('mode_color')->each(function($site) use($linkPreview){
                $response = $linkPreview->get($site->url);
                $site->fill($response->toArray());
                $site->save();
                $this->info("save: ". $site->url);
                sleep(5);
            });
        } catch (LinkPreviewRuntimeException $e) {
            // dd($e);
            $this->error($e->getMessage());
            return Command::FAILURE;
        } catch (Exception $e) {
            // dd($e);
            $this->error($e->getMessage());
            return Command::FAILURE;
        }
        $this->line("end site:access");
        return Command::SUCCESS;
    }
}
