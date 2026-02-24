# Field Mapping Reference - Production Update

## Old Field Names → New Field Names

### F0 (1 field)
- `f0_inisiasi_solusi` → `f0_inisiasi_solusi` ✓ (OK)

### F1 (1 field)  
- OLD: `f1_p0_p1` → NEW: `f1_tech_budget` ❌

### F2 (7 fields)
- OLD: `f1_juskeb` → NEW: `f2_p0_p1` ❌
- `f2_p2` → `f2_p2` ✓ (OK)
- OLD: `f1_bod_dm` → NEW: `f2_p3` ❌
- OLD: `f2_evaluasi` → NEW: `f2_p4` ❌
- OLD: `f2_taf` → NEW: `f2_offering` ❌
- OLD: `f2_juskeb` → NEW: `f2_p5` ❌
- OLD: `f2_bod_dm` → NEW: `f2_proposal` ❌

### F3 (3 fields)
- OLD: `f3_p3_1` → NEW: `f3_p6` ❌
- OLD: `f3_sph` → NEW: `f3_p7` ❌
- OLD: `f3_juskeb` → NEW: `f3_submit` ❌

### F4 (1 field)
- OLD: `f4_p3_2` → NEW: `f4_negosiasi` ❌

### F5 (3 fields)
- OLD: `f4_pks` → NEW: `f5_sk_mitra` ❌
- OLD: `f4_bast` → NEW: `f5_ttd_kontrak` ❌
- OLD: `f5_p4` → NEW: `f5_p8` ❌

### DELIVERY (4 fields → 3 checkboxes + 2 text indicators)
- OLD: `f5_p5` → NEW: `delivery_kontrak` (checkbox) ❌
- OLD: `delivery_baso` → NEW: Show indicator if `delivery_baut_bast` has value (text indicator) ❌
- OLD: `f5_kontrak_layanan` → NEW: Show indicator if `delivery_baso` has value (text indicator) ❌
- OLD: `delivery_billing` → **REMOVE** (field doesn't exist, redundant) ❌

### BILLING (already correct)
- `delivery_billing_complete` ✓
- `delivery_nilai_billcomp` ✓

## Binding Update
ALL field access must change from:
```
{{ $funnel && $funnel->fieldname ? 'checked' : '' }}
```

To:
```
{{ $funnel && $funnel->todayProgress && $funnel->todayProgress->fieldname ? 'checked' : '' }}
```

## Notes
- `delivery_baut_bast` and `delivery_baso` are STRING fields for document numbers (not booleans)
- In user views, we show them as indicators (✓ if has value, - if empty)
- Admin can input actual values via funnel-form
