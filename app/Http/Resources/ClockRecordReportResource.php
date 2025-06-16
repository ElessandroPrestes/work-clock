<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClockRecordReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   public function toArray(Request $request): array
    {
        return [
            'registro_id' => $this->registro_id,
            'funcionario' => $this->funcionario,
            'cargo' => $this->position,
            'idade' => (int) $this->idade,
            'gestor' => $this->gestor ?? 'N/A',
            'data_hora' => date('Y-m-d H:i:s', strtotime($this->data_hora)),
        ];
    }
}
