<?php
namespace App\Usecases;

use App\Models\NgWord;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

final class NgWordCreate
{
    /**
     * @param array<string, mixed> $data
     * @return NgWord
     * @throws ValidationException
     */
    public function __invoke(array $data): NgWord
    {
        try {
            DB::beginTransaction();
            $ngWord = NgWord::create($data);
            Tag::where('name', $ngWord->word)->delete();
            DB::commit();
            return $ngWord;
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            Log::error(__METHOD__ . PHP_EOL . var_export($e->getMessage(), true));
            throw ValidationException::withMessages([
                'word' => 'すでに登録されています。'
            ]);
        }
    }
}