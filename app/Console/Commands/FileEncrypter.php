<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FileEncrypter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:encrypt {s3path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $storage = Storage::disk('ctb');

        $fileExists = $storage->exists($this->argument('s3path'));

        if (! $fileExists) {
            $this->error("File doesn't exists");
            return;
        }

        $this->encryptFile($this->argument('s3path'));

    }

   /**
     * Encrypt and upload a file to a given S3 path.
     *
     * @param string $filePath
     * @return void
     */
    private function encryptFile(string $filePath)
    {
        $key = env('FILE_ENCRYPTION_KEY'); // The key to use for encryption

        $cipher = "AES-256-ECB"; // Change to AES-256-ECB

        $disk = Storage::disk('ctb');

        $fileContent = $disk->get($filePath);
    
        $encryptedData = openssl_encrypt($fileContent, $cipher, $key, OPENSSL_RAW_DATA);

        $disk->put("encrypteds/".str_replace("uploads/", "", $filePath).".enc", $encryptedData);

        return "success";
    }
}
