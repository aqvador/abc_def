# Раз в минуту удаляем ЗР которые пришли к нам  больше 720 минут назад
* * * * * find "/app/records/" -type f -mmin +10 -exec rm -rf {} \;

# Раз в пол часа, удаляем отработанные звонки из статистики всех звонков
*/30 * * * * /usr/local/bin/php /app/yii crone-pipeline/remove-old-calls

# Каждое воскресенье наполняем abc_def, если наполнить не удается, то работать будет прошлый abc_def
1 0 * * Sun /usr/local/bin/php /app/yii numbers/abc-def/parse-resource-numeration
