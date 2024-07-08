<?php
namespace App\Livewire\Forms;

use App\Models\StatusLog;
use App\Models\Transaksi;
use App\Models\Customer;
use App\Models\ClaimedVoucher;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Str; // Import Str for generating unique ID

class TransaksiForm extends Form
{
    public $customer_id;
    public $description;
    public $items;
    public $discount;
    public $price;
    public $status;
    public $id;
    public $created_at;
    public $voucher_id;
    public ?Transaksi $transaksi;
    
    public function setTransaksi(Transaksi $transaksi)
    {
        $this->transaksi = $transaksi;
        $this->id = $transaksi->id;
        $this->customer_id = $transaksi->customer_id;
        $this->description = $transaksi->description;
        $this->items = $transaksi->items;
        $this->price = $transaksi->price;
        $this->status = $transaksi->status;
        $this->discount = $transaksi->discount;
        $this->created_at = $transaksi->created_at;
        $this->voucher_id = $transaksi->voucher_id;
    }

    public function store()
    {
        $validate = $this->validateData();
        $validate['id'] = $this->generateUniqueTransactionId();


        $transaksi = Transaksi::create($validate);
        $this->createStatusLog($validate['id'], 'dibayar');
        
        $points = floor($this->price / 1000); // 1 point for every Rp 1.000,00 spent
        $customer = Customer::find($this->customer_id);
        $customer->points += $points;
        $customer->save();
        
        $claimedVoucher = ClaimedVoucher::find($this->voucher_id);
        if ($claimedVoucher) {
            $claimedVoucher->update(['used_at' => now()]);
        }

        $this->reset();
    }

    public function update()
    {
        $validate = $this->validateStatus();

        $this->transaksi->update(['status' => $validate['status']]);
        $this->createStatusLog($this->transaksi->id, $this->status);

        $this->reset();
    }

    private function validateStatus()
    {
        return $this->validate([
            'status' => 'required',
        ]);
    }

    private function validateData($isUpdate = false)
    {
        $rules = [
            'customer_id' => 'required',
            'description' => 'required',
            'items' => 'required',
            'price' => 'required',
            'voucher_id' => 'nullable',
            'discount' => 'nullable',
        ];

        if ($isUpdate) {
            $rules['status'] = 'required';
        }

        $validate = $this->validate($rules);
        $validate['items'] = json_encode($validate['items']);

        return $validate;
    }

    private function createStatusLog($transaksiId, $status)
    {
        StatusLog::create([
            'transaksi_id' => $transaksiId,
            'status' => $status,
            'changed_at' => now(),
        ]);
    }

    protected function generateUniqueTransactionId()
    {
        // Generate a unique ID using current timestamp and a random string
        return 'TRX-' . now()->format('YmdHis') . '-' . Str::random(6);
    }
}
