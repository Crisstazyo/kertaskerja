# PRODUCTION-READY FIX PATTERN FOR ALL ROLES
## Private, SOE, SME LOP Views

---

## COMPREHENSIVE FIELD MAPPING (Apply to ALL LOP views)

### Data Attributes (data-field="...")
```
OLD → NEW

F1:
f1_p0_p1 → f1_tech_budget

F2:
f1_juskeb → f2_p0_p1
f2_p2 → f2_p2 (UNCHANGED)
f1_bod_dm → f2_p3
f2_evaluasi → f2_p4
f2_taf → f2_offering
f2_juskeb → f2_p5
f2_bod_dm → f2_proposal

F3:
f3_p3_1 → f3_p6
f3_sph → f3_p7
f3_juskeb → f3_submit

F4:
f4_p3_2 → f4_negosiasi

F5:
f4_pks → f5_sk_mitra
f4_bast → f5_ttd_kontrak
f5_p4 → f5_p8

DELIVERY:
f5_p5 → delivery_kontrak
delivery_baso → delivery_baut_bast (BUT THIS IS TEXT, NOT CHECKBOX!)
f5_kontrak_layanan → delivery_baso (BUT THIS IS TEXT, NOT CHECKBOX!)
delivery_billing → REMOVE (doesn't exist)
```

### Checkbox Bindings ({{ $funnel->field }})
```
OLD:
{{ $funnel && $funnel->f1_p0_p1 ? 'checked' : '' }}

NEW:
{{ $funnel && $funnel->todayProgress && $funnel->todayProgress->f1_tech_budget ? 'checked' : '' }}
```

### DELIVERY Section Special Handling

**CURRENT WRONG STRUCTURE:**
```blade
<!-- Kontrak (checkbox) -->
<input ... data-field="f5_p5" {{ $funnel && $funnel->f5_p5 ? 'checked' : '' }}>

<!-- BAUT/BAST (WRONG - this is checkbox but should be TEXT) -->
<input ... data-field="delivery_baso" {{ $funnel && $funnel->delivery_baso ? 'checked' : '' }}>

<!-- BASO (WRONG - this is checkbox but should be TEXT) -->
<input ... data-field="f5_kontrak_layanan" {{ $funnel && $funnel->f5_kontrak_layanan ? 'checked' : '' }}>

<!-- Billing (WRONG - field doesn't exist) -->
<input ... data-field="delivery_billing" {{ $funnel && $funnel->delivery_billing ? 'checked' : '' }}>
```

**PRODUCTION-READY STRUCTURE:**
```blade
<!-- Kontrak (checkbox) -->
<input ... data-field="delivery_kontrak" 
       {{ $funnel && $funnel->todayProgress && $funnel->todayProgress->delivery_kontrak ? 'checked' : '' }}>

<!-- BAUT/BAST (TEXT DISPLAY - NO CHECKBOX!) -->
{{ $funnel && $funnel->delivery_baut_bast ? $funnel->delivery_baut_bast : '-' }}

<!-- BASO (TEXT DISPLAY - NO CHECKBOX!) -->
{{ $funnel && $funnel->delivery_baso ? $funnel->delivery_baso : '-' }}

<!-- REMOVE the "Billing" column completely -->
<!-- Table header should be colspan="3" not colspan="4" -->
```

### NILAI BILL COMP Logic
```php
@php
    $todayProgress = $funnel ? $funnel->todayProgress : null;
@endphp
@if($todayProgress && $todayProgress->delivery_billing_complete)
    {{ number_format($todayProgress->delivery_nilai_billcomp, 0, ',', '.') }}
@else
    -
@endif
```

---

## IMPLEMENTATION CHECKLIST PER FILE

### For EACH lop-on-hand.blade.php:
- [ ] Fix header: DELIVERY colspan 4 → 3
- [ ] Update data-field="f1_p0_p1" → "f1_tech_budget"
- [ ] Update data-field="f1_juskeb" → "f2_p0_p1"
- [ ] Update data-field="f1_bod_dm" → "f2_p3"
- [ ] Update data-field="f2_evaluasi" → "f2_p4"
- [ ] Update data-field="f2_taf" → "f2_offering"
- [ ] Update data-field="f2_juskeb" → "f2_p5"
- [ ] Update data-field="f2_bod_dm" → "f2_proposal"
- [ ] Update data-field="f3_p3_1" → "f3_p6"
- [ ] Update data-field="f3_sph" → "f3_p7"
- [ ] Update data-field="f3_juskeb" → "f3_submit"
- [ ] Update data-field="f4_p3_2" → "f4_negosiasi"
- [ ] Update data-field="f4_pks" → "f5_sk_mitra"
- [ ] Update data-field="f4_bast" → "f5_ttd_kontrak"
- [ ] Update data-field="f5_p4" → "f5_p8"
- [ ] Update data-field="f5_p5" → "delivery_kontrak"
- [ ] Replace delivery_baso checkbox → text display delivery_baut_bast
- [ ] Replace f5_kontrak_layanan checkbox → text display delivery_baso
- [ ] REMOVE delivery_billing checkbox column
- [ ] Update ALL bindings {{ $funnel->field }} → {{ $funnel->todayProgress->field }}
- [ ] Update NILAI BILL COMP logic to use todayProgress
- [ ] Fix footer colspan if needed

### For EACH lop-qualified.blade.php:
- Same as lop-on-hand
- Data type: "qualified"

### For EACH lop-initiate.blade.php (Private/SOE/SME have "initiated"):
- Same as lop-on-hand
- Data type: "initiated" (NOT "initiate"!)
- May use different collection structure (check each file)

### For EACH lop-koreksi.blade.php (Private/SOE/SME have "correction"):
- Same as lop-on-hand
- Data type: "correction" (NOT "koreksi"!)

---

## FILES TO UPDATE

### Private Role (4 files):
1. resources/views/private/lop-on-hand.blade.php
2. resources/views/private/lop-qualified.blade.php
3. resources/views/private/lop-initiate.blade.php (check: data-data-type="initiated")
4. resources/views/private/lop-koreksi.blade.php (check: data-data-type="correction")

### SOE Role (4 files):
1. resources/views/soe/lop-on-hand.blade.php
2. resources/views/soe/lop-qualified.blade.php
3. resources/views/soe/lop-initiate.blade.php (data-data-type="initiated")
4. resources/views/soe/lop-koreksi.blade.php (data-data-type="correction")

### SME Role (4 files):
1. resources/views/sme/lop-on-hand.blade.php
2. resources/views/sme/lop-qualified.blade.php
3. resources/views/sme/lop-initiate.blade.php (data-data-type="initiated")
4. resources/views/sme/lop-koreksi.blade.php (data-data-type="correction")

**Total: 12 files**

---

## TESTING STRATEGY

After fixing each role:
1. Clear views: `php artisan view:clear`
2. Check errors: `get_errors` on all 4 files
3. Test checkbox update via AJAX
4. Verify data saved to task_progress table
5. Verify todayProgress displays correctly

---

## PRIORITY EXECUTION

1. **Private role first** (business critical)
2. **SOE role second**
3. **SME role third**

---

*Document Created: February 24, 2026*
*Status: Ready for systematic implementation*
