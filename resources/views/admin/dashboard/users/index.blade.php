<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>الإيرادات</title>

    <!-- Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --topbar: #3f5564;
            --thead: #5c87a6;
            --panel-border: #cfd6dd;
            --panel-bg: #ffffff;
            --muted: #7a8793;

            --btn: #5c87a6;
            --btn-hover: #4f7691;

            --input-border: #8fc0ff;
            --shadow: 0 8px 24px rgba(0, 0, 0, .08);
        }

        body {
            background: #fff;
            font-family: system-ui, -apple-system, "Segoe UI", Tahoma, Arial;
            height: 100vh;
            overflow: hidden;
        }

        /* ===== Topbar ===== */
        .app-topbar {
            height: 52px;
            background: var(--topbar);
            color: #fff;
            display: flex;
            align-items: center;
            padding: 0 14px;
            gap: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .app-topbar .title {
            flex: 1;
            text-align: center;
            font-weight: 700;
            letter-spacing: .2px;
        }

        .app-topbar .icon-btn {
            width: 34px;
            height: 34px;
            border: 0;
            background: transparent;
            color: #eaf1f7;
            display: grid;
            place-items: center;
            border-radius: 8px;
            transition: .2s;
        }

        .app-topbar .icon-btn:hover {
            background: rgba(255, 255, 255, .10);
        }

        /* ===== Layout ===== */
        .app {
            height: calc(100vh - 52px);
            display: grid;
            grid-template-columns: 460px 1fr;
            grid-template-areas: "panel table";
            gap: 14px;
            padding: 12px;
        }

        .panel {
            grid-area: panel;
            background: var(--panel-bg);
            border: 2px solid var(--panel-border);
            box-shadow: var(--shadow);
            padding: 16px 16px 14px;
            overflow: auto;
        }

        .table-wrap {
            grid-area: table;
            background: #fff;
            border: 1px solid var(--panel-border);
            box-shadow: var(--shadow);
            overflow: auto;
            position: relative;
        }

        /* ===== Table ===== */
        table.rev {
            width: 100%;
            border-collapse: collapse;
        }

        table.rev thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: var(--thead);
            color: #fff;
            font-weight: 700;
            padding: 10px 12px;
            border-bottom: 1px solid rgba(0, 0, 0, .10);
            white-space: nowrap;
            text-align: center;
        }

        table.rev tbody td {
            padding: 16px 12px;
            border-bottom: 1px solid #e9eef2;
            vertical-align: middle;
            white-space: nowrap;
            text-align: center;
        }

        table.rev tbody tr:hover {
            background: #fafcff;
        }

        .t-action {
            width: 90px;
            text-align: center;
        }

        .t-action i {
            cursor: pointer;
            opacity: .85;
            transition: .15s;
        }

        .t-action i:hover {
            opacity: 1;
            transform: translateY(-1px);
        }

        /* ===== Total (bottom center) ===== */
        .total-bar {
            position: sticky;
            bottom: 0;
            background: #fff;
            border-top: 1px solid #e9eef2;
            padding: 12px 10px;
            text-align: center;
            font-size: 13px;
            color: #2c3e50;
            font-weight: 600;
        }

        /* ===== Panel head ===== */
        .panel-head {
            text-align: center;
            padding-top: 8px;
            padding-bottom: 10px;
        }

        .panel-head .icon {
            font-size: 44px;
            color: #5a6b7a;
            margin-bottom: 6px;
        }

        .panel-head .panel-title {
            color: #2d8bd6;
            font-weight: 700;
            font-size: 16px;
            margin: 0;
        }

        .form-label {
            font-size: 13px;
            color: #6b7785;
            margin-top: 10px;
            margin-bottom: 6px;
            text-align: right;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--input-border);
            border-radius: 2px;
            padding: 10px 12px;
            box-shadow: none !important;
            height: 44px;
            font-size: 13px;
        }

        textarea.form-control {
            height: auto;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #5aa5ff;
            box-shadow: 0 0 0 .2rem rgba(90, 165, 255, .15) !important;
        }

        .btn-save {
            background: var(--btn);
            border: 0;
            color: #fff;
            width: 100%;
            padding: 12px 14px;
            border-radius: 4px;
            font-weight: 700;
            margin-top: 12px;
            transition: .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-save:hover {
            background: var(--btn-hover);
        }

        /* ===== Responsive ===== */
        @media (max-width: 1100px) {
            body { overflow: auto; }
            .app {
                height: auto;
                grid-template-columns: 1fr;
                grid-template-areas: "table";
            }
            .panel { display: none; }
        }
    </style>
</head>

<body>

<!-- Topbar -->
<div class="app-topbar">
    <button class="icon-btn" type="button" title="بحث">
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>

    <button class="icon-btn" type="button" title="تحديث" id="refreshBtn">
        <i class="fa-solid fa-rotate-right"></i>
    </button>

    <div class="title">الإيرادات</div>

    <button class="icon-btn" type="button" title="رجوع" onclick="history.back()">
        <i class="fa-solid fa-right-long"></i>
    </button>
</div>

<div class="app">

    <!-- Right panel (Form) -->
    <div class="panel">
        <div class="panel-head">
            <div class="icon"><i class="fa-solid fa-coins"></i></div>
            <p class="panel-title">تسجيل الإيرادات</p>
        </div>

        <div class="mb-2">
            <label class="form-label">المبلغ</label>
            <input class="form-control" type="number" placeholder="">
        </div>

        <div class="mb-2">
            <label class="form-label">عنوان العقار</label>
            <input class="form-control" type="text" placeholder="">
        </div>

        <div class="mb-2">
            <label class="form-label">اسم المالك</label>
            <input class="form-control" type="text" placeholder="">
        </div>

        <div class="mb-2">
            <label class="form-label">الوصف</label>
            <select class="form-select">
                <option selected disabled value="">الوصف</option>
                <option>عقد إيجار</option>
                <option>عقد بيع</option>
                <option>سند صرف</option>
                <option>أخرى</option>
            </select>
        </div>

        <div class="mb-2">
            <label class="form-label">التاريخ</label>
            <input class="form-control" type="date" placeholder="">
        </div>

        <button class="btn-save" type="button">
            <i class="fa-solid fa-left-long"></i>
            تسجيل البيانات
        </button>
    </div>

    <!-- Table -->
    <div class="table-wrap">
        <table class="rev">
            <thead>
            <tr>
                <th style="width: 170px;">المبلغ</th>
                <th style="width: 260px;">الوصف</th>
                <th style="width: 180px;">التاريخ</th>
                <th class="t-action">تعديل</th>
                <th class="t-action">حذف</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>12000</td>
                <td>عقد بيع</td>
                <td>2024-05-12</td>
                <td class="t-action"><i class="fa-solid fa-pen-to-square"></i></td>
                <td class="t-action"><i class="fa-solid fa-trash text-danger"></i></td>
            </tr>

            <tr>
                <td>1200</td>
                <td>سند صرف</td>
                <td>2024-05-12</td>
                <td class="t-action"><i class="fa-solid fa-pen-to-square"></i></td>
                <td class="t-action"><i class="fa-solid fa-trash text-danger"></i></td>
            </tr>

            <tr>
                <td>1200</td>
                <td>عقد إيجار</td>
                <td>2024-05-12</td>
                <td class="t-action"><i class="fa-solid fa-pen-to-square"></i></td>
                <td class="t-action"><i class="fa-solid fa-trash text-danger"></i></td>
            </tr>

            <tr>
                <td>10000</td>
                <td>عقد إيجار</td>
                <td>2024-05-04</td>
                <td class="t-action"><i class="fa-solid fa-pen-to-square"></i></td>
                <td class="t-action"><i class="fa-solid fa-trash text-danger"></i></td>
            </tr>

            <tr>
                <td>20000</td>
                <td>عقد بيع</td>
                <td>2024-05-04</td>
                <td class="t-action"><i class="fa-solid fa-pen-to-square"></i></td>
                <td class="t-action"><i class="fa-solid fa-trash text-danger"></i></td>
            </tr>
            </tbody>
        </table>

        <!-- total -->
        <div class="total-bar">الإجمالي : 44400</div>
    </div>

</div>

<script>
    // Refresh
    document.getElementById("refreshBtn").addEventListener("click", () => location.reload());
</script>
</body>

</html>
