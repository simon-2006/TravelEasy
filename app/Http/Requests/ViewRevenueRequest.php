<?php

namespace App\Http\Requests;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ViewRevenueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string|Rule>>
     */
    public function rules(): array
    {
        return [
            'periode' => [
                'nullable',
                'string',
                Rule::in(['deze_week', 'deze_maand', 'dit_kwartaal', 'dit_jaar', 'aangepast']),
            ],
            'van_datum' => ['nullable', 'date', 'required_if:periode,aangepast'],
            'tot_datum' => ['nullable', 'date', 'required_if:periode,aangepast', 'after_or_equal:van_datum'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'periode.in' => 'Kies een geldige periode.',
            'van_datum.required_if' => 'Vul een startdatum in voor een aangepaste periode.',
            'tot_datum.required_if' => 'Vul een einddatum in voor een aangepaste periode.',
            'tot_datum.after_or_equal' => 'De einddatum moet gelijk of later zijn dan de startdatum.',
        ];
    }

    /**
     * @return array{periode: string, label: string, from: CarbonImmutable, to: CarbonImmutable}
     */
    public function periodRange(): array
    {
        $validatedPeriod = $this->validated('periode');
        $period = is_string($validatedPeriod) ? $validatedPeriod : 'deze_maand';
        $today = CarbonImmutable::today();

        if ($period === 'deze_week') {
            return [
                'periode' => $period,
                'label' => 'deze week',
                'from' => $today->startOfWeek(),
                'to' => $today->endOfWeek(),
            ];
        }

        if ($period === 'dit_kwartaal') {
            return [
                'periode' => $period,
                'label' => 'dit kwartaal',
                'from' => $today->startOfQuarter(),
                'to' => $today->endOfQuarter(),
            ];
        }

        if ($period === 'dit_jaar') {
            return [
                'periode' => $period,
                'label' => 'dit jaar',
                'from' => $today->startOfYear(),
                'to' => $today->endOfYear(),
            ];
        }

        if ($period === 'aangepast') {
            $from = CarbonImmutable::parse((string) $this->validated('van_datum'))->startOfDay();
            $to = CarbonImmutable::parse((string) $this->validated('tot_datum'))->endOfDay();

            return [
                'periode' => $period,
                'label' => 'aangepaste periode',
                'from' => $from,
                'to' => $to,
            ];
        }

        return [
            'periode' => 'deze_maand',
            'label' => 'deze maand',
            'from' => $today->startOfMonth(),
            'to' => $today->endOfMonth(),
        ];
    }

    public function hasSubmittedFilter(): bool
    {
        return $this->query->has('periode')
            || $this->query->has('van_datum')
            || $this->query->has('tot_datum');
    }
}
