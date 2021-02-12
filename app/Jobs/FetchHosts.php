<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

class FetchHosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $url;

    #[Pure] public function __construct(private string $recipe = ''){}

    public function handle()
    {
        $this->url = "https://raw.githubusercontent.com/StevenBlack/hosts/master/{$this->getUrl()}hosts";
        $hosts = $this->downloadHosts();
        $this->saveJson($hosts);
    }

    private function getUrl(): string
    {
        return match (Str::lower($this->recipe)) {
            'fakenews' => 'alternates/fakenews/',
            'gambling' => 'alternates/gambling/',
            'porn' => 'alternates/porn/',
            'social' => 'alternates/social/',
            'fakenews-gambling' => 'alternates/fakenews-gambling/',
            'fakenews-porn' => 'alternates/fakenews-porn/',
            'fakenews-social' => 'alternates/fakenews-social/',
            'gambling-porn' => 'alternates/gambling-porn/',
            'gambling-social' => 'alternates/gambling-social/',
            'porn-social' => 'alternates/porn-social/',
            'fakenews-gambling-porn' => 'alternates/fakenews-gambling-porn/',
            'fakenews-gambling-social' => 'alternates/fakenews-gambling-social/',
            'fakenews-porn-social' => 'alternates/fakenews-porn-social/',
            'gambling-porn-social' => 'alternates/gambling-porn-social/',
            'fakenews-gambling-porn-social' => 'alternates/fakenews-gambling-porn-social/',
            default => '',
        };
    }

    private function downloadHosts(): string
    {
        $response = Http::get($this->url);
        $hosts = Str::of($response->body())
            ->after('# Start StevenBlack')
            ->replace('0.0.0.0', '')
            ->replace(' ', '')
            ->explode("\n");

        return collect($hosts)
            ->filter(fn($host) => $host && !str_contains($host, '#'))
            ->values()
            ->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * @param string $hosts
     */
    private function saveJson(string $hosts): void
    {
        $file_name = $this->getUrl() ? "hosts-{$this->recipe}.json" : "hosts.json";
        File::put(public_path($file_name), $hosts);
    }

}
