<?php

#mail---------------------------------------------------------------------------

$_['default_mail_subject']  = '{store_name}  - {product_name} прибыл(а) к нам на склад!';

$_['default_mail_body'] = 
'Привет {user_name}!<br/> <br/> 
Вы просили напомнить когда {product_name} прибудет к нам на склад.
<br/><br/> 
Вы можете приобрести его кликнув по ссылке: {product_link}
<br/><br/> 
Спасибо за проявленный интерес к нашим товарам.
<br/> <br/>
С уважением
<br/> <br/>
{store_name}';


#mail admin--------------------------------------------------------------------

$_['default_mail_subject_admin'] = '{store_name} -  Сообщения что {product_name} доступен для заказа отправлены.';

$_['default_mail_body_admin'] =
'Привет!
<br/> <br/> 
Сообщения что {product_name} доступен для заказа доставлены.
<br/> <br/> 
С уважением,
<br/> <br/>
{store_name}';
 

$_['option_warning'] = '
<b style="color:red">Будьте внимательны:</b>
Перед тем как удалить опцию или ее значение проверьте что пользователи не ждут эти опции, 
{heading_title}, проверяет склад по "опции IDs"and "значение опции IDs", 
если вы удалите то пользователи не получат уведомления.
';

// Heading
$_['heading_title'] = 'Уведомление о приходе на склад 3.6';

$_['button_notify'] = 'Выслать оповещения (послать e-mails)';
 
$_['entry_show_mode'] = 'Нет на складе товаров в списках:<br/><span class="help">Категории, Лучшие и так далее</span>';

$_['entry_notify_button'] = 'Кнопка в серых тонах: <span class="help">Оставить кнопку "В корзину" в серых тонах в категориях и других модулях?</span>';
$_['entry_notify_admin'] = 'Уведомить администрацию о новых запросах? <span class="help">Если да то админы получат уведомления e-mail каждый раз когда пользователь просит привезти товар.</span>';
 
$_['entry_notify_mode'] = 'Тип оповещения:';

$_['entry_customer_group'] = 'Игнорировать группу покупателей:<span class="help">Выберите группу покупателей которым не будет показываться модуль</span>';

$_['entry_nwa_cron_key'] = 'Cron job support<span class="help">
 To setup a cron job, you must define a cron key here to bypass admin login. <br/>(left empty to disable).</span>';

$_['entry_nwa_cron_key_tip'] = '
 <span class="help"> <br/>
 After defining a key, setup your cron job software to access the following link: <br/>
 http://YOURSTORE.COM/admin/index.php?route=module/notify_when_arrives/notify<b style="color:red;">&nwa_cron_key=YOUR_DEFINED_KEY</b>
</span>';

$_['entry_mail_costumer'] = 'Тело письма покупателя:
  <span class="help">Используются следующие словосочетания:<br/>
  <b>{user_name}</b> Для имени клиента<br/>
  <b>{user_phone}</b> Для телефона клиента<br/>
  <b>{user_custom}</b> на пользовательское поле клиента data<br/>
  <b>{product_name}</b> Для названия товара<br/>
  <b>{product_link}</b> Для ссылки на товар<br/>
  <b>{store_name}</b> Для имени магазина<br/>
';

$_['entry_mail_admin'] = 'тело письма Admin mail body:
  <span class="help">Используются следующие словосочетания:<br/>
  <b>{product_name}</b> Для имени товара<br/>
  <b>{product_link}</b> Для ссылки на товар<br/>
  <b>{store_name}</b> для названия магазина<br/>';

$_['entry_subject_costumer'] = 'Тема письма покупателя:';
$_['entry_subject_admin'] = 'Тема письма админа:';

$_['entry_stock_status'] = 'Игнорировать статусы склада:<br/>
<span class="help">Даже если количество будет равно 0.</span>    
';

$_['entry_nwa_replace_mode'] = 'Тип замены на странице товара:<br/>
<span class="help">Если расширение ищет уродливые (или не показывать) на страницу продукции тему, попробуйте изменить режим совместимости, если проблема не устранена, свяжитесь с нами по системе OpenCart комментариев.</span>    
';

$_['entry_fields'] = 'Какие поля показыватьn<span class="help">Выберите, какие поля вы хотите использовать. Пользовательские поля не поддерживает многоязычные.</span>';

$_['entry_custom_name'] = 'Имя поля';
$_['entry_custom_type'] = 'Тип данных';

$_['entry_install'] = 'База данных модуля:';

$_['entry_layout'] = 'Разметка';
$_['entry_position'] = 'Позиция';
$_['entry_sort_order'] = 'Порядок';
$_['entry_status'] = 'Статус модуля:';

$_['text_nwa_replace_default'] = 'По умолчанию';
$_['text_nwa_replace_compatibility'] = 'Режим совместимости';
$_['text_nwa_replace_append'] = 'Добавить, Не удалять кнопку в корзину.';
$_['text_nwa_replace_popup'] = 'Показывать всплывающее окошко.';

$_['text_use_email'] = 'Использовать поле email';
$_['text_use_name'] =  'Использовать поле имя пользователя';
$_['text_use_phone'] = 'Использовать поле телефона';
$_['text_use_custom'] = 'Использовать пользовательские поля';

$_['text_custom_type_number'] = 'Только цифры (0-9)';
$_['text_custom_type_text'] = 'Только текст (a-z | A-Z)';
$_['text_custom_type_text_number'] = 'И текст и цифры (a-z | A-Z | 0-9)';
$_['text_custom_type_any'] = 'Любой тип данных';
 
$_['text_nwa_not_logged_users'] = 'Не залогиненые пользователи';

$_['text_module'] = 'Модули';

$_['text_success'] = 'Модуль Уведомление о приходе на склад 3.6 успешно изменен';

$_['text_show_both'] = 'Показывать форму по клику и наведению мышкой. <span class="help" style="display:inline">(Работает не со всеми темами)</span>';
$_['text_show_click'] = 'Показывать форму только по клику.';
$_['text_show_redirect'] = 'Переходить на страничку товара и показывать форму там.';
$_['text_show_popup'] = 'Показывать всплывающее окошко. <span class="help" style="display:inline">(Работает по клику)</span>';

$_['text_no_data'] = 'Нет данных!';

$_['text_tip_layout'] = 'Вызов модуля<span class="help">Здесь вы должны добавить модуль во всех макетов вы планируете использовать. По умолчанию должно быть в макетах <b>Главная</b>, <b>Товар</b>,<b>Категория</b> и <b>Default</b></span>';

$_['text_product_name'] = 'Имя товара';
$_['text_product_requested'] = 'Количество предзаказов';
$_['text_product_notified'] = 'Количество уведомлений';
$_['text_product_emails'] = 'Покупателей ожидающих уведомления <span class="help">Порядок отображения: Имя | E-mail | Телефон | Custom</span>';

$_['text_view_mails'] = 'Показать покупателей';
$_['text_hide_mails'] = 'Спрятать покупателей';

$_['text_delete_statistic'] = 'Удалить статистику?';
$_['text_delete_ok'] = 'Статистика удалена!';
$_['text_delete_error'] = 'Ошибка удаления!';
$_['text_confirm_delete'] = 'Вы уверены что хотите удалить статистику?';

$_['text_updated'] = 'Список оповещений обновлен!';
$_['text_wait_count'] = 'Покупатели ждущие товары';
$_['text_wait_count_cron'] = 'Результат работы Cron: {count_sent} e-mails было послано. {count_wait} Покупателей ждущих товары.';

$_['tab_general'] = 'Настройка';
$_['tab_statistics'] = 'Статистика';
$_['tab_mail'] = 'E - Mail';

$_['text_installed'] = '<span style="color:green">Установлено</span>';

$_['text_install_success'] = '<span style="color:green">Установлено успешно!</span>';
$_['text_install_error'] = '<span style="color:red"> Ошибка установки!</span>
                             <span class="help">
                             Система не смогла выполнить установку базы данных.<br/>
                             Запустите SQL файл в папку модуля вручную в базе данных для продолжения установки.<br/>
                             Модуль не будет работать без установки базы данных
                             </ span> ';

$_['text_notify_auto'] = 'Автоматически';
$_['text_notify_manual'] = 'Вручную';

$_['tip_notify_mode'] = ' <span class="help">В ручном режиме вы должны нажать кнопку "Уведомить сейчас" что бы послать e-mails</span>';

$_['text_content_top'] = 'Контент сверху';
$_['text_content_bottom'] = 'Контент снизу';
$_['text_column_left'] = 'Левая колонка';
$_['text_column_right'] = 'Правая колонка';

// Error
$_['error_permission'] = 'Ошибка: У вас нет прав редактировать модуль Уведомление о приходе на склад 3.6!';
$_['error_product_name'] = '<span style="color:red">Ошибка: Этот товар (id = %s) отсутствует в списке товаров</span>';

?>