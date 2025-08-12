<?php

namespace App\Console\Commands;

use App\Models\CardTopup;
use App\Services\CardTopupService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoCheckCardInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-check-card-invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra thẻ cào đang ở trạng thái pending';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = $countFailed = 0;

        CardTopup::where('status', 'pending')
            ->orderBy('id', 'desc')
            ->chunk(50, function ($cards) use (&$count, &$countFailed) {
                foreach ($cards as $card) {
                    $cardPayload = [
                        'telco'      => $card->network,
                        'amount'     => $card->amount,
                        'code'       => $card->code,
                        'serial'     => $card->serial,
                        'request_id' => $card->request_id,
                    ];

                    try {
                        $cardResponse = CardTopupService::cardToPartner($cardPayload, 'check');

                        $isSuccess = $cardResponse['status'] == 1;

                        $card->update([
                            // 'status'           => $isSuccess ? 'success' : 'failed',
                            'status'           => 'success',
                            'response_message' => $cardResponse['message'] ?? ''
                        ]);

                        $isSuccess ? $count++ : $countFailed++;
                    } catch (\Throwable $e) {
                        Log::error("Lỗi khi check thẻ {$card->code}: " . $e->getMessage(), [
                            'card_id'    => $card->id,
                            'request_id' => $card->request_id
                        ]);
                        $this->info("Không thể xác nhận thẻ {$card->code}.");
                    }
                }
            });

        $this->info("Đã xác nhận {$count} thẻ cào đúng và {$countFailed} thẻ cào không hợp lệ.");
    }
}
