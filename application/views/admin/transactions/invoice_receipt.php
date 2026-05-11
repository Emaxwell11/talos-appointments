<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?= html_escape($title) ?></title>
<style>
body { font-family: Arial, sans-serif; font-size: 14px; color: #222; }
.wrap { max-width: 820px; margin: 24px auto; }
.head { display: flex; justify-content: space-between; }
h2 { margin: 0; }
.box { border: 1px solid #ddd; padding: 12px; margin-top: 16px; }
table { width: 100%; border-collapse: collapse; margin-top: 16px; }
th, td { border: 1px solid #eee; padding: 10px; text-align: left; }
th { background: #f9f9f9; }
.total { text-align: right; font-weight: bold; }
.actions { margin-top: 16px; }
.btn { display: inline-block; padding: 8px 12px; border: 1px solid #333; text-decoration: none; margin-right: 8px; }
.small { color: #666; font-size: 12px; }
</style>
</head>
<body>
<div class="wrap">
  <div class="head">
    <div>
      <h2><?= html_escape($this->settings->site_name ?? 'Payment Portal') ?></h2>
      <div class="small"><?= html_escape(base_url()) ?></div>
    </div>
    <div>
      <div><?= ucfirst($doc_type) ?> #<?= (int)$tx['id'] ?></div>
      <div>Date: <?= html_escape(date('Y-m-d H:i', strtotime($tx['created_at']))) ?></div>
      <div>Ref: <?= html_escape($tx['payment_intent']) ?></div>
    </div>
  </div>

  <div class="box">
    <strong>Item</strong><br>
    <?= html_escape($tx['product_name'] ?? 'Payment') ?><br>
    <span class="small"><?= html_escape($tx['payment_description'] ?? $tx['product_description'] ?? '') ?></span>
  </div>

  <table>
    <thead>
      <tr>
        <th>Description</th>
        <th style="width: 160px;">Amount</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?= ucfirst($doc_type) ?> for transaction #<?= (int)$tx['id'] ?></td>
        <td><?= html_escape(($tx['currency'] ?: 'NGN').' '.number_format((float)$tx['amount'], 2)) ?></td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td class="total">Total</td>
        <td class="total"><?= html_escape(($tx['currency'] ?: 'NGN').' '.number_format((float)$tx['amount'], 2)) ?></td>
      </tr>
    </tfoot>
  </table>

  <div class="box small">
    Status: <?= html_escape($tx['status']) ?>, Pay link ID: <?= (int)$tx['user_pay_link_id'] ?>
  </div>

  <div class="actions">
    <a class="btn" target="_blank" href="<?= base_url('admin/paylinks/invoice/'.$tx['id']) ?>">Open invoice</a>
    <a class="btn" href="<?= base_url('admin/paylinks/receipt/'.$tx['id'].'?download=1') ?>">Download receipt</a>
  </div>
</div>
</body>
</html>
