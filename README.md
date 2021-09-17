# period
締め日を指定して期間の開始日と終了日を取得する

## Install
利用するプロジェクトの `composer.json` に以下を追加する。
```composer.json
"repositories": {
    "period": {
        "type": "vcs",
        "url": "https://github.com/shimoning/period.git"
    }
},
```

その後以下でインストールする。

```bash
composer require shimoning/period
```

## Usage

### Monthly
月の締め日を指定して、月の開始日と終了日を取得する。

```php
$period = Monthly::period(2020, 4, 20);

echo $period['start']->year; // 2020
echo $period['start']->month; // 3
echo $period['start']->day; // 21

echo $period['end']->year; // 2020
echo $period['end']->month; // 4
echo $period['end']->day; // 20
```

31日がない月で、31日を締め日に指定すると、その前日が締め日として扱われる。
```php
$period = Monthly::period(2019, 2, 31);

echo $period['start']->year; // 2019
echo $period['start']->month; // 2
echo $period['start']->day; // 1

echo $period['end']->year; // 2019
echo $period['end']->month; // 2
echo $period['end']->day; // 28
```

### Yearly
年の締め日を指定して、年の開始日と終了日を取得する。
年度の期間などに使う。

```php
$period = Yearly::period(2020, 4, 20);

echo $period['start']->year; // 2019
echo $period['start']->month; // 4
echo $period['start']->day; // 21

echo $period['end']->year; // 2020
echo $period['end']->month; // 4
echo $period['end']->day; // 20
```

31日がない月で、31日を締め日に指定すると、その前日が締め日として扱われる。
```php
$period = Yearly::period(2019, 2, 31);

echo $period['start']->year; // 2018
echo $period['start']->month; // 3
echo $period['start']->day; // 1

echo $period['end']->year; // 2019
echo $period['end']->month; // 2
echo $period['end']->day; // 28
```
