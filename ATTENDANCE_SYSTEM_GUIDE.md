# 📋 Daily Attendance System Guide

## Overview

The daily attendance system provides a simple yet powerful way to track athlete attendance with automatic daily resets and comprehensive historical records.

### Key Features

✅ **Daily Attendance Check-In**
- Coaches mark attendance for today only
- Four status options: Present, Absent, Late, Excused
- Optional remarks field for notes (e.g., "Injured", "Early dismissal")

🔄 **Automatic Daily Reset**
- Tomorrow automatically opens new attendance records
- No manual reset needed
- Clean separation between today and history

📜 **Attendance History**
- All past records archived automatically
- Monthly calendar view with color-coded statuses
- Filter by month and year
- Visual matrix showing attendance patterns

🎯 **Coach & Admin Roles**
- **Coaches**: Manage attendance for their assigned athletes
- **Admins**: View and manage all athlete attendance
- Coach ID tracked with each record

---

## Database Schema

### `attendances` Table

| Column | Type | Notes |
|--------|------|-------|
| `id` | BIGINT | Primary key |
| `athlete_id` | BIGINT | Foreign key to athletes table |
| `coach_id` | BIGINT/NULL | Foreign key to coaches table |
| `date` | DATE | Attendance date (defaults to today) |
| `status` | ENUM | present, absent, late, excused |
| `remarks` | TEXT | Optional comments |
| `created_at` | TIMESTAMP | Record creation time |
| `updated_at` | TIMESTAMP | Last update time |

**Unique Constraint**: `(athlete_id, date)` - Prevents duplicate records per athlete per day

---

## Attendance Statuses

| Status | Use Case | Color | Notes |
|--------|----------|-------|-------|
| **Present** | Athlete attended | 🟢 Green | Default status |
| **Absent** | Athlete did not attend | 🔴 Red | Unexcused absence |
| **Late** | Athlete arrived late | 🟡 Yellow | Still counts as attendance |
| **Excused** | Athlete absent with excuse | 🔵 Blue | Approved absence |

---

## User Workflows

### Coach Workflow

1. **Access Attendance**
   - Navigate to "Coach" → "Attendance"
   - View today's date prominently displayed
   - See all assigned athletes

2. **Check Attendance**
   - Click "Check Attendance" button
   - Modal opens with today's date (read-only)
   - For each athlete:
     - Click status button to cycle through: Present → Absent → Late → Excused → Present
     - Add remarks if needed (optional)

3. **Save Records**
   - Click "Save Attendance"
   - Records saved with coach ID and timestamp
   - Confirmation message shown

4. **View History**
   - Click "Attendance History" button
   - Select month and year
   - View calendar matrix of attendance

### Admin Workflow

1. **Access Attendance**
   - Navigate to "Admin" → "Attendance"
   - Filter by sport, month, or specific date (optional)

2. **Manage Attendance**
   - View all athletes' attendance
   - Same status toggle interface as coaches
   - Can override any record

3. **Historical Analysis**
   - Use "Attendance History" for detailed monthly reports
   - Color-coded matrix shows patterns at a glance

---

## How the Daily Reset Works

### Today's Behavior
- ✏️ Records are **editable** today
- Date field is **read-only** (fixed to today)
- Can only save attendance for today
- Any updates override previous records

### Tomorrow's Behavior
- 📋 Yesterday's records move to **history**
- New attendance slots open for today
- Past records remain in `attendances` table
- Can view/compare with historical data

### No Data Loss
- All records permanently stored
- Historical view preserves all past data
- Can review attendance patterns over time

---

## API/Route Reference

### Coach Routes

```
GET  /coach/attendance           → coachIndex (view today's attendance)
POST /coach/attendance           → store (save attendance records)
GET  /attendance/history         → history (view past records)
```

### Admin Routes

```
GET  /admin/attendance           → adminIndex (view all attendance with filters)
```

---

## Technical Implementation

### Model Methods

**Attendance Model**
```php
// Check if record is for today
$attendance->isToday();

// Check if record can be edited (must be today)
$attendance->isEditable();

// Relationships
$attendance->athlete();
$attendance->coach();
```

### Key Validations

1. **Date Validation**: Only today's date accepted in `store()`
2. **Unique Constraint**: Only one record per athlete per date
3. **Role Check**: Coaches can only modify their own athletes' attendance
4. **Coach Tracking**: Coach ID automatically included from authenticated user

---

## Status Flow Diagram

```
┌──────────────────────────────────────────────────────────┐
│ Attendance System - Daily Cycle                           │
├──────────────────────────────────────────────────────────┤
│                                                           │
│  TODAY:                                                  │
│  ✏️ Open for attendance marking                          │
│  Date: Fixed to today (read-only)                        │
│  Status: Can cycle through all 4 options                 │
│  Editable: YES                                           │
│                                                           │
│  ⬇️ Time progresses to midnight ⬇️                       │
│                                                           │
│  TOMORROW:                                               │
│  📋 Yesterday's records → History                        │
│  ✏️ New attendance available for today                   │
│  Date: Fixed to new today                               │
│  Status: Can cycle through all 4 options                 │
│  Editable: YES                                           │
│                                                           │
│  🔄 Repeats daily...                                     │
│                                                           │
└──────────────────────────────────────────────────────────┘
```

---

## Report Examples

### Quick Status Check (Attendance Page)
- Shows current status for each athlete
- Editable indicator (✏️ Today vs 📋 History)
- Remarks visible in table

### Historical Monthly Report
- Calendar matrix with color-coded cells
- One cell per day per athlete
- Color legend:
  - 🟢 Green = Present
  - 🟡 Yellow = Late
  - 🔵 Blue = Excused
  - 🔴 Red = Absent
  - ⚪ Gray = No Record

---

## Testing

Run the comprehensive test suite:

```bash
php artisan test tests/Feature/AttendanceSystemTest.php
```

Tests cover:
✅ Today-only attendance recording
✅ Status updates
✅ All four statuses supported
✅ Coach tracking (coach_id)
✅ Remarks storage
✅ Historical records preservation
✅ Editable flag for today

---

## Future Enhancements

- 📱 Mobile app for quick check-in
- 📧 Email notifications for absences
- 📊 Attendance statistics/reports
- 🔔 Alerts for frequent absences
- 🏅 Attendance badges/rewards
- 📲 SMS notifications
- 🚨 Auto-excuse system (holidays, events)
