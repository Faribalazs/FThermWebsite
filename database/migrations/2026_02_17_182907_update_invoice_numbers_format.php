<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\WorkOrder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all existing invoice numbers to new format (YY-ID)
        $workOrders = WorkOrder::whereNotNull('invoice_number')->get();
        
        foreach ($workOrders as $workOrder) {
            // Extract year from created_at and format as YY-ID
            $year = substr($workOrder->created_at->format('Y'), -2);
            $newInvoiceNumber = $year . '-' . $workOrder->id;
            
            $workOrder->update([
                'invoice_number' => $newInvoiceNumber
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally restore old format if needed
        // This is left empty as the old format cannot be reliably restored
    }
};
