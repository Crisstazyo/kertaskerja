<?php
private function upsertRisingStar(int $typeId, array $values): RisingStar
{
    // ← Gunakan periode dari $values jika ada, fallback ke bulan berjalan
    $periode = isset($values['periode']) ? $values['periode'] : now()->format('Y-m-01');

    $last = RisingStar::where('user_id', auth()->id())
        ->where('type_id', $typeId)
        ->where('periode', $periode)
        ->where('is_latest', true)
        ->first();

    $realRatio     = isset($values['real_ratio']) ? $values['real_ratio'] : ($last?->real_ratio);
    $realUpdatedAt = isset($values['real_ratio']) ? now() : ($last?->real_updated_at);

    $result = DB::transaction(function () use ($typeId, $periode, $values, $last, $realRatio, $realUpdatedAt) {
        RisingStar::where('user_id', auth()->id())
            ->where('type_id', $typeId)
            ->where('periode', $periode)
            ->update(['is_latest' => false]);

        return RisingStar::create([
            'user_id'         => auth()->id(),
            'type_id'         => $typeId,
            'periode'         => $periode,
            'status'          => 'active',
            'is_latest'       => true,
            'commitment'      => $values['commitment'] ?? ($last?->commitment),
            'real_ratio'      => $realRatio,
            'real_updated_at' => $realUpdatedAt,
        ]);
    });

    return $result;
}