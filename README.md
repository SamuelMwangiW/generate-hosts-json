## About
This project is a simple Laravel application that downloads hosts files from @StevenBlack [hosts repository](https://github.com/StevenBlack/hosts/)
and generates JSON files. 

I consume the JSON files with an Adblocker chrome extension that am working on but you're free to do with the JSON files as you please.

##Scheduling
To schedule regular update to the json files, add a cron job as follows

```shell
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
or locally as follows:
```shell
php artisan schedule:work
```

If using a queue as opposed to `sync`, you need to have queue processing running in the background:
```shell
php artisan queue:work
```
You may also adjust the update frequency in `app/Console/Kernel.php` as desired
```php
$schedule->job(new FetchHosts($option))->everyMinute()
                ->withoutOverlapping();
```
##File Locations
|Host file recipe | Relative JSON File URI |
---------------- |:------:
Unified hosts = **(adware + malware)** | `/hosts.json`
Unified hosts + fakenews| `/hosts-fakenews.json`
Unified hosts + gambling| `/hosts-gambling.json`
Unified hosts + porn| `/hosts-porn.json`
Unified hosts + social| `/hosts-social.json`
Unified hosts + fakenews + gambling| `/hosts-fakenews-gambling.json`
Unified hosts + fakenews + porn| `/hosts-fakenews-porn.json`
Unified hosts + fakenews + social| `/hosts-fakenews-social.json`
Unified hosts + gambling + porn| `/hosts-gambling-porn.json`
Unified hosts + gambling + social| `/hosts-gambling-social.json`
Unified hosts + porn + social| `/hosts-porn-social.json`
Unified hosts + fakenews + gambling + porn| `/hosts-fakenews-gambling-porn.json`
Unified hosts + fakenews + gambling + social| `/hosts-fakenews-gambling-social.json`
Unified hosts + fakenews + porn + social| `/hosts-fakenews-porn-social.json`
Unified hosts + gambling + porn + social| `/hosts-gambling-porn-social.json`
Unified hosts + fakenews + gambling + porn + social| `/hosts-fakenews-gambling-porn-socialjson`
