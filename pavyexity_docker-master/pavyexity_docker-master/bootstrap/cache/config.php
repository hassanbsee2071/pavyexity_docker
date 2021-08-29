<?php return array (
  'analytics' => 
  array (
    'google-analytics' => 'UA-XXXXX-X',
  ),
  'app' => 
  array (
    'name' => 'Payvexity',
    'env' => 'local',
    'debug' => true,
    'debug_emails' => NULL,
    'url' => 'http://localhost',
    'timezone' => 'UTC',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'locales' => NULL,
    'key' => 'base64:RYrVSBk9dZ8e5OiOJ4BMf1907mkfFM7KBpHaJJ/pEnE=',
    'cipher' => 'AES-256-CBC',
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'Laravel\\Tinker\\TinkerServiceProvider',
      23 => 'Arcanedev\\LogViewer\\LogViewerServiceProvider',
      24 => 'Collective\\Html\\HtmlServiceProvider',
      25 => 'Creativeorange\\Gravatar\\GravatarServiceProvider',
      26 => 'DaveJamesMiller\\Breadcrumbs\\BreadcrumbsServiceProvider',
      27 => 'Laravel\\Socialite\\SocialiteServiceProvider',
      28 => 'AlbertCht\\InvisibleReCaptcha\\InvisibleReCaptchaServiceProvider',
      29 => 'App\\Providers\\AppServiceProvider',
      30 => 'App\\Providers\\AuthServiceProvider',
      31 => 'App\\Providers\\EventServiceProvider',
      32 => 'App\\Providers\\RouteServiceProvider',
      33 => 'App\\Providers\\ToJsServiceProvider',
      34 => 'App\\Providers\\MetaServiceProvider',
      35 => 'Kyslik\\ColumnSortable\\ColumnSortableServiceProvider',
      36 => 'App\\Providers\\ProtectionProvider',
      37 => 'niklasravnsborg\\LaravelPdf\\PdfServiceProvider',
      38 => 'Yajra\\DataTables\\DataTablesServiceProvider',
      39 => 'App\\Providers\\MailConfigServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'LogActivity' => 'App\\Helpers\\LogActivity',
      'Breadcrumbs' => 'DaveJamesMiller\\Breadcrumbs\\Facade',
      'Form' => 'Collective\\Html\\FormFacade',
      'Html' => 'Collective\\Html\\HtmlFacade',
      'Gravatar' => 'Creativeorange\\Gravatar\\Facades\\Gravatar',
      'Socialite' => 'Laravel\\Socialite\\Facades\\Socialite',
      'ToJs' => 'App\\Helpers\\ToJs\\Facades\\ToJsFacade',
      'Meta' => 'App\\Helpers\\Meta\\Facades\\MetaFacade',
      'PDF' => 'niklasravnsborg\\LaravelPdf\\Facades\\Pdf',
      'DataTables' => 'Yajra\\DataTables\\Facades\\DataTables',
    ),
    'db_fields' => 
    array (
      0 => 'email',
      1 => 'amount',
      2 => 'description',
      3 => 'ignore this column',
    ),
    'schedule_db_fields' => 
    array (
      0 => 'email',
      1 => 'amount',
      2 => 'intervals',
      3 => 'start_date',
      4 => 'end_date',
      5 => 'description',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'token',
        'provider' => 'users',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\Auth\\User\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
      ),
    ),
    'users' => 
    array (
      'registration' => true,
      'default_role' => 'authenticated',
      'confirm_email' => true,
      'change_email' => false,
    ),
    'socialite' => 
    array (
      'except_roles' => 
      array (
        0 => 'Super User',
      ),
      'session_name' => 'socialite_provider',
    ),
    'captcha' => 
    array (
      'registration' => false,
    ),
  ),
  'breadcrumbs' => 
  array (
    'view' => 'breadcrumbs::bootstrap3',
    'files' => '/var/www/routes/breadcrumbs.php',
    'unnamed-route-exception' => true,
    'missing-route-bound-breadcrumb-exception' => true,
    'invalid-named-breadcrumb-exception' => true,
    'manager-class' => 'DaveJamesMiller\\Breadcrumbs\\BreadcrumbsManager',
    'generator-class' => 'DaveJamesMiller\\Breadcrumbs\\BreadcrumbsGenerator',
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' => 
        array (
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => '/var/www/storage/framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
    ),
    'prefix' => 'laravel',
  ),
  'captcha' => 
  array (
    'siteKey' => '',
    'secretKey' => '',
    'options' => 
    array (
      'hideBadge' => false,
      'dataBadge' => 'bottomright',
      'timeout' => 5,
      'debug' => false,
    ),
    'hideBadge' => false,
    'debug' => false,
  ),
  'columnsortable' => 
  array (
    'columns' => 
    array (
      'alpha' => 
      array (
        'rows' => 
        array (
          0 => 'description',
          1 => 'email',
          2 => 'name',
          3 => 'slug',
        ),
        'class' => 'fa fa-sort-alpha',
      ),
      'amount' => 
      array (
        'rows' => 
        array (
          0 => 'amount',
          1 => 'price',
        ),
        'class' => 'fa fa-sort-amount',
      ),
      'numeric' => 
      array (
        'rows' => 
        array (
          0 => 'created_at',
          1 => 'updated_at',
          2 => 'level',
          3 => 'id',
          4 => 'phone_number',
        ),
        'class' => 'fa fa-sort-numeric',
      ),
    ),
    'enable_icons' => true,
    'default_icon_set' => 'fa fa-sort',
    'sortable_icon' => 'fa fa-sort',
    'clickable_icon' => false,
    'icon_text_separator' => ' ',
    'asc_suffix' => '-asc',
    'desc_suffix' => '-desc',
    'anchor_class' => NULL,
    'active_anchor_class' => NULL,
    'direction_anchor_class_prefix' => NULL,
    'uri_relation_column_separator' => '.',
    'formatting_function' => 'ucfirst',
    'format_custom_titles' => true,
    'inject_title_as' => NULL,
    'allow_request_modification' => true,
    'default_direction' => 'asc',
    'default_direction_unsorted' => 'asc',
    'default_first_column' => false,
    'join_type' => 'leftJoin',
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'database' => 
  array (
    'default' => 'sqlsrv',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'database' => 'payvexity_docker',
        'prefix' => '',
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => 'mssql-46754-0.cloudclusters.net,19865',
        'port' => '3306',
        'database' => 'payvexity_docker',
        'username' => 'root',
        'password' => '190814Aa',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'host' => 'mssql-46754-0.cloudclusters.net,19865',
        'port' => '5432',
        'database' => 'payvexity_docker',
        'username' => 'root',
        'password' => '190814Aa',
        'charset' => 'utf8',
        'prefix' => '',
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'host' => 'mssql-46754-0.cloudclusters.net,19865',
        'database' => 'payvexity_docker',
        'username' => 'root',
        'password' => '190814Aa',
        'prefix' => '',
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'predis',
      'default' => 
      array (
        'host' => '127.0.0.1',
        'password' => '',
        'port' => '6379',
        'database' => 0,
      ),
    ),
  ),
  'datatables' => 
  array (
    'search' => 
    array (
      'smart' => true,
      'multi_term' => true,
      'case_insensitive' => true,
      'use_wildcards' => false,
      'starts_with' => false,
    ),
    'index_column' => 'DT_RowIndex',
    'engines' => 
    array (
      'eloquent' => 'Yajra\\DataTables\\EloquentDataTable',
      'query' => 'Yajra\\DataTables\\QueryDataTable',
      'collection' => 'Yajra\\DataTables\\CollectionDataTable',
      'resource' => 'Yajra\\DataTables\\ApiResourceDataTable',
    ),
    'builders' => 
    array (
    ),
    'nulls_last_sql' => ':column :direction NULLS LAST',
    'error' => NULL,
    'columns' => 
    array (
      'excess' => 
      array (
        0 => 'rn',
        1 => 'row_num',
      ),
      'escape' => '*',
      'raw' => 
      array (
        0 => 'action',
      ),
      'blacklist' => 
      array (
        0 => 'password',
        1 => 'remember_token',
      ),
      'whitelist' => '*',
    ),
    'json' => 
    array (
      'header' => 
      array (
      ),
      'options' => 0,
    ),
  ),
  'debugbar' => 
  array (
    'enabled' => NULL,
    'except' => 
    array (
      0 => 'telescope*',
      1 => 'horizon*',
    ),
    'storage' => 
    array (
      'enabled' => true,
      'driver' => 'file',
      'path' => '/var/www/storage/debugbar',
      'connection' => NULL,
      'provider' => '',
    ),
    'include_vendors' => true,
    'capture_ajax' => true,
    'add_ajax_timing' => false,
    'error_handler' => false,
    'clockwork' => false,
    'collectors' => 
    array (
      'phpinfo' => true,
      'messages' => true,
      'time' => true,
      'memory' => true,
      'exceptions' => true,
      'log' => true,
      'db' => true,
      'views' => true,
      'route' => true,
      'laravel' => false,
      'events' => false,
      'default_request' => false,
      'symfony_request' => true,
      'mail' => true,
      'logs' => false,
      'files' => false,
      'config' => false,
      'auth' => false,
      'gate' => false,
      'session' => true,
    ),
    'options' => 
    array (
      'auth' => 
      array (
        'show_name' => false,
      ),
      'db' => 
      array (
        'with_params' => true,
        'timeline' => false,
        'backtrace' => false,
        'explain' => 
        array (
          'enabled' => false,
          'types' => 
          array (
            0 => 'SELECT',
          ),
        ),
        'hints' => true,
      ),
      'mail' => 
      array (
        'full_log' => false,
      ),
      'views' => 
      array (
        'data' => false,
      ),
      'route' => 
      array (
        'label' => true,
      ),
      'logs' => 
      array (
        'file' => NULL,
      ),
    ),
    'inject' => true,
    'route_prefix' => '_debugbar',
    'route_domain' => NULL,
    'theme' => 'auto',
    'debug_backtrace_limit' => 50,
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'cloud' => 's3',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => '/var/www/storage/app',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => '/var/www/storage/app/public',
        'url' => 'http://localhost/storage',
        'visibility' => 'public',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => NULL,
        'secret' => NULL,
        'region' => NULL,
        'bucket' => NULL,
      ),
    ),
  ),
  'gravatar' => 
  array (
    'default' => 
    array (
      'size' => 80,
      'fallback' => 'mm',
      'secure' => false,
      'maximumRating' => 'g',
      'forceDefault' => false,
      'forceExtension' => 'jpg',
    ),
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => 10,
    ),
    'argon' => 
    array (
      'memory' => 1024,
      'threads' => 2,
      'time' => 2,
    ),
  ),
  'ide-helper' => 
  array (
    'filename' => '_ide_helper',
    'meta_filename' => '.phpstorm.meta.php',
    'include_fluent' => false,
    'include_factory_builders' => false,
    'write_model_magic_where' => true,
    'write_model_external_builder_methods' => true,
    'write_model_relation_count_properties' => true,
    'write_eloquent_model_mixins' => false,
    'include_helpers' => false,
    'helper_files' => 
    array (
      0 => '/var/www/vendor/laravel/framework/src/Illuminate/Support/helpers.php',
    ),
    'model_locations' => 
    array (
      0 => 'app',
    ),
    'ignored_models' => 
    array (
    ),
    'extra' => 
    array (
      'Eloquent' => 
      array (
        0 => 'Illuminate\\Database\\Eloquent\\Builder',
        1 => 'Illuminate\\Database\\Query\\Builder',
      ),
      'Session' => 
      array (
        0 => 'Illuminate\\Session\\Store',
      ),
    ),
    'magic' => 
    array (
      'Log' => 
      array (
        'debug' => 'Monolog\\Logger::addDebug',
        'info' => 'Monolog\\Logger::addInfo',
        'notice' => 'Monolog\\Logger::addNotice',
        'warning' => 'Monolog\\Logger::addWarning',
        'error' => 'Monolog\\Logger::addError',
        'critical' => 'Monolog\\Logger::addCritical',
        'alert' => 'Monolog\\Logger::addAlert',
        'emergency' => 'Monolog\\Logger::addEmergency',
      ),
    ),
    'interfaces' => 
    array (
    ),
    'custom_db_types' => 
    array (
    ),
    'model_camel_case_properties' => false,
    'type_overrides' => 
    array (
      'integer' => 'int',
      'boolean' => 'bool',
    ),
    'include_class_docblocks' => false,
    'force_fqn' => false,
    'additional_relation_types' => 
    array (
    ),
    'format' => 'php',
  ),
  'log-viewer' => 
  array (
    'storage-path' => '/var/www/storage/logs',
    'pattern' => 
    array (
      'prefix' => 'laravel-',
      'date' => '[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]',
      'extension' => '.log',
    ),
    'locale' => 'auto',
    'theme' => 'bootstrap-4',
    'route' => 
    array (
      'enabled' => true,
      'attributes' => 
      array (
        'prefix' => 'admin/log-viewer',
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
      ),
    ),
    'per-page' => 30,
    'download' => 
    array (
      'prefix' => 'laravel-',
      'extension' => 'log',
    ),
    'menu' => 
    array (
      'filter-route' => 'log-viewer::logs.filter',
      'icons-enabled' => true,
    ),
    'icons' => 
    array (
      'all' => 'fa fa-fw fa-list',
      'emergency' => 'fa fa-fw fa-bug',
      'alert' => 'fa fa-fw fa-bullhorn',
      'critical' => 'fa fa-fw fa-heartbeat',
      'error' => 'fa fa-fw fa-times-circle',
      'warning' => 'fa fa-fw fa-exclamation-triangle',
      'notice' => 'fa fa-fw fa-exclamation-circle',
      'info' => 'fa fa-fw fa-info-circle',
      'debug' => 'fa fa-fw fa-life-ring',
    ),
    'colors' => 
    array (
      'levels' => 
      array (
        'empty' => '#D1D1D1',
        'all' => '#8A8A8A',
        'emergency' => '#B71C1C',
        'alert' => '#D32F2F',
        'critical' => '#F44336',
        'error' => '#FF5722',
        'warning' => '#FF9100',
        'notice' => '#4CAF50',
        'info' => '#1976D2',
        'debug' => '#90CAF9',
      ),
    ),
    'highlight' => 
    array (
      0 => '^#\\d+',
      1 => '^Stack trace:',
    ),
    'facade' => 'LogViewer',
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => '/var/www/storage/logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => '/var/www/storage/logs/laravel.log',
        'level' => 'debug',
        'days' => 7,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'critical',
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
    ),
  ),
  'mail' => 
  array (
    'driver' => 'smtp',
    'host' => 'smtp.mailtrap.io',
    'port' => '2525',
    'from' => 
    array (
      'address' => 'support@payvexity.com',
      'name' => 'Payvexity',
    ),
    'encryption' => 'tls',
    'username' => '98ceb47bb8b6d4',
    'password' => '62557f10645875',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false,
  ),
  'meta' => 
  array (
    'defaults' => 
    array (
      'title' => 'Payvexity',
      'description' => NULL,
      'keywords' => NULL,
      'author' => NULL,
      'copyright' => NULL,
      'robots' => 'INDEX, FOLLOW',
      'og' => 
      array (
        'title' => 'Payvexity',
        'image' => NULL,
        'description' => NULL,
        'type' => NULL,
        'site_name' => 'Payvexity',
      ),
      'twitter' => 
      array (
        'title' => 'Payvexity',
        'image' => NULL,
        'description' => NULL,
        'card' => NULL,
        'site' => NULL,
        'creator' => NULL,
      ),
      'dc' => 
      array (
        'title' => 'Payvexity',
        'description' => NULL,
        'subject' => NULL,
        'identifier' => 'Payvexity',
        'creator' => NULL,
        'publisher' => NULL,
        'rights_holder' => NULL,
        'type' => 'Text',
        'format' => 'text/html',
        'language' => 'en',
        'rights' => NULL,
        'audience' => NULL,
      ),
    ),
    'title_suffix' => '| Payvexity',
  ),
  'pdf' => 
  array (
    'mode' => 'utf-8',
    'format' => 'A4',
    'author' => '',
    'subject' => '',
    'keywords' => '',
    'creator' => 'Laravel Pdf',
    'display_mode' => 'fullpage',
    'tempDir' => '/var/www/storage/app/mpdf',
    'pdf_a' => false,
    'pdf_a_auto' => false,
    'icc_profile_path' => '',
  ),
  'protection' => 
  array (
    'connection' => 
    array (
      'username' => 'laravel',
      'password' => 'laravel',
      'api_key' => '2e4cbe88-662a-48f9-b5e4-9226f17b2e4d',
      'security_mode' => 'APIKEY',
    ),
    'product_number' => 'LB-DEMO',
    'defaults' => 
    array (
      'licensee' => 
      array (
        'number' => 'email',
        'name' => 'name',
      ),
      'shop' => 
      array (
        'success_url' => NULL,
        'success_url_title' => 'Return to Laravel Boilerplate',
        'cancel_url' => NULL,
        'cancel_url_title' => 'Cancel and return to Laravel Boilerplate',
      ),
    ),
    'except_roles' => 
    array (
      0 => 'Super User',
    ),
    'membership' => 
    array (
      'product_module_number' => 'LB-SUBSCRIPTION-PLAN',
    ),
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => 'your-public-key',
        'secret' => 'your-secret-key',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'region' => 'us-east-1',
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
      ),
    ),
    'failed' => 
    array (
      'database' => 'sqlsrv',
      'table' => 'failed_jobs',
    ),
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
    ),
    'ses' => 
    array (
      'key' => NULL,
      'secret' => NULL,
      'region' => 'us-east-1',
    ),
    'sparkpost' => 
    array (
      'secret' => NULL,
    ),
    'stripe' => 
    array (
      'model' => 'App\\Models\\Auth\\User\\User',
      'key' => NULL,
      'secret' => NULL,
    ),
    'bitbucket' => 
    array (
      'client_id' => NULL,
      'client_secret' => NULL,
      'redirect' => NULL,
      'scopes' => 
      array (
      ),
      'with' => 
      array (
      ),
    ),
    'facebook' => 
    array (
      'client_id' => NULL,
      'client_secret' => NULL,
      'redirect' => NULL,
      'scopes' => 
      array (
      ),
      'with' => 
      array (
      ),
      'fields' => 
      array (
      ),
    ),
    'github' => 
    array (
      'client_id' => NULL,
      'client_secret' => NULL,
      'redirect' => NULL,
      'scopes' => 
      array (
      ),
      'with' => 
      array (
      ),
    ),
    'google' => 
    array (
      'client_id' => NULL,
      'client_secret' => NULL,
      'redirect' => NULL,
      'scopes' => 
      array (
        0 => 'https://www.googleapis.com/auth/plus.me',
        1 => 'https://www.googleapis.com/auth/plus.profile.emails.read',
      ),
      'with' => 
      array (
      ),
    ),
    'linkedin' => 
    array (
      'client_id' => NULL,
      'client_secret' => NULL,
      'redirect' => NULL,
      'scopes' => 
      array (
      ),
      'with' => 
      array (
      ),
      'fields' => 
      array (
      ),
    ),
    'twitter' => 
    array (
      'client_id' => NULL,
      'client_secret' => NULL,
      'redirect' => NULL,
      'scopes' => 
      array (
      ),
      'with' => 
      array (
      ),
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => '/var/www/storage/framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => '/var/www/resources/views',
    ),
    'compiled' => '/var/www/storage/framework/views',
  ),
  'wallet' => 
  array (
    'math' => 
    array (
      'scale' => 64,
    ),
    'package' => 
    array (
      'rateable' => 'Bavix\\Wallet\\Simple\\Rate',
      'storable' => 'Bavix\\Wallet\\Simple\\Store',
      'mathable' => 'Bavix\\Wallet\\Simple\\BrickMath',
    ),
    'lock' => 
    array (
      'cache' => NULL,
      'enabled' => false,
      'seconds' => 1,
    ),
    'currencies' => 
    array (
    ),
    'services' => 
    array (
      'exchange' => 'Bavix\\Wallet\\Services\\ExchangeService',
      'common' => 'Bavix\\Wallet\\Services\\CommonService',
      'wallet' => 'Bavix\\Wallet\\Services\\WalletService',
      'lock' => 'Bavix\\Wallet\\Services\\LockService',
    ),
    'objects' => 
    array (
      'bring' => 'Bavix\\Wallet\\Objects\\Bring',
      'cart' => 'Bavix\\Wallet\\Objects\\Cart',
      'emptyLock' => 'Bavix\\Wallet\\Objects\\EmptyLock',
      'operation' => 'Bavix\\Wallet\\Objects\\Operation',
    ),
    'transaction' => 
    array (
      'table' => 'transactions',
      'model' => 'Bavix\\Wallet\\Models\\Transaction',
      'casts' => 
      array (
        'amount' => 'string',
      ),
    ),
    'transfer' => 
    array (
      'table' => 'transfers',
      'model' => 'Bavix\\Wallet\\Models\\Transfer',
      'casts' => 
      array (
        'fee' => 'string',
      ),
    ),
    'wallet' => 
    array (
      'table' => 'wallets',
      'model' => 'Bavix\\Wallet\\Models\\Wallet',
      'casts' => 
      array (
        'balance' => 'string',
      ),
      'creating' => 
      array (
      ),
      'default' => 
      array (
        'name' => 'Default Wallet',
        'slug' => 'default',
        'meta' => 
        array (
        ),
      ),
    ),
  ),
  'dompdf' => 
  array (
    'show_warnings' => false,
    'orientation' => 'portrait',
    'defines' => 
    array (
      'font_dir' => '/var/www/storage/fonts/',
      'font_cache' => '/var/www/storage/fonts/',
      'temp_dir' => '/tmp',
      'chroot' => '/var/www',
      'enable_font_subsetting' => false,
      'pdf_backend' => 'CPDF',
      'default_media_type' => 'screen',
      'default_paper_size' => 'a4',
      'default_font' => 'serif',
      'dpi' => 96,
      'enable_php' => false,
      'enable_javascript' => true,
      'enable_remote' => true,
      'font_height_ratio' => 1.1,
      'enable_html5_parser' => false,
    ),
  ),
  'generators' => 
  array (
    'config' => 
    array (
      'migration_template_path' => '/var/www/vendor/kitloong/laravel-migrations-generator/src/Way/Generators/templates/migration.txt',
      'migration_target_path' => '/var/www/database/migrations',
    ),
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);
