<?php

// 1.0 General Routes

// 1.1 Home and About Pages
$router->get('/', 'HomeController@index');
$router->get('/books', 'BookController@index');
$router->get('/search', 'SearchController@index');
$router->get('/contact-us', 'ContactController@index');
$router->get('/about-us', 'AboutController@us');
$router->get('/about-project', 'AboutController@project');
$router->get('/health', 'HomeController@health');

// 1.2 Contact Form Submission
$router->post('/contact/message', 'ContactController@message');

// 1.3 Book and Campaign Pages
$router->get('/books/{shopkeeper_book_id}', 'BookController@show');
$router->get('/campaigns/{campaign_id}', 'CampaignController@show');
$router->get('/search/books', 'SearchController@search');

// 2.0 Cart Routes

// 2.1 View Cart and Actions
$router->get('/cart/{user_id}', 'CartController@index', ['auth']);
$router->post('/cart/{user_id}/finalize', 'CartController@finalize', ['auth']);
$router->delete('/cart/{user_cart_id}/make-empty', 'CartController@make_empty', ['auth']);
$router->post('/cart/{user_cart_id}/calculate', 'CartController@calculate', ['auth']);
$router->post('/cart/{user_cart_id}/quantity/{cart_item_id}', 'CartController@change_quantity', ['auth']);
$router->delete('/cart/{user_cart_id}/remove/{cart_item_id}', 'CartController@remove_item', ['auth']);
$router->post('/cart/{user_cart_id}/add/{shopkeeper_book_id}', 'CartController@store', ['auth']);

// 3.0 Authentication Routes

// 3.1 Sign-in, Login, and Logout
$router->get('/auth/signin', 'UserController@signin', ['gust']);
$router->post('/auth/signin', 'UserController@store', ['gust']);
$router->get('/auth/login', 'UserController@login', ['gust']);
$router->post('/auth/login', 'UserController@authenticate', ['gust']);
$router->post('/auth/logout', 'UserController@logout', ['auth']);

// 4.0 Panel Routes (Admin and User Dashboards)

// 4.1 Dashboard and User Management
$router->get('/panel/dashboard', 'PanelController@dashboard', ['auth']);
$router->get('/panel/user/{user_id}/edit', 'UserController@edit', ['auth']);
$router->get('/panel/order-history', 'OrderController@index', ['auth']);
$router->get('/panel/order-history/{order_id}', 'OrderController@show', ['auth']);
$router->get('/panel/users', 'UserController@index', ['auth', 'owner']);
$router->get('/panel/users/create', 'UserController@create', ['auth', 'owner']);
$router->get('/panel/settings', 'SettingController@index', ['auth', 'owner']);

// 4.2 Shopkeeper Requests
$router->get('/panel/requests/to-be-shopkeeper', 'ShopkeeperController@index', ['auth', 'highs']);
$router->get('/panel/requests/{user_id}/to-be-shopkeeper', 'ShopkeeperController@show', ['auth', 'user']);
$router->get('/panel/requests/{user_id}/to-be-shopkeeper/request', 'ShopkeeperController@create', ['auth', 'user']);

// 4.3 Manage Books and Campaigns
$router->get('/panel/manage/books', 'ManageBooksController@index', ['auth', 'highs']);
$router->get('/panel/manage/books/approved', 'ManageBooksController@approved', ['auth', 'highs']);
$router->get('/panel/manage/books/pending', 'ManageBooksController@pending', ['auth', 'highs']);
$router->get('/panel/manage/books/rejected', 'ManageBooksController@rejected', ['auth', 'highs']);
$router->get('/panel/manage/books/stopped', 'ManageBooksController@stopped', ['auth', 'highs']);
$router->get('/panel/manage/books/{shopkeeper_id}', 'ManageBooksController@show', ['auth', 'shopkeeper']);
$router->get('/panel/manage/books/{shopkeeper_id}/add', 'ManageBooksController@create', ['auth', 'shopkeeper']);
$router->get('/panel/manage/books/{shopkeeper_id}/edit/{shopkeeper_book_id}', 'ManageBooksController@edit', ['auth', 'no_user']);
$router->get('/panel/manage/campaigns', 'ManageCampaignsController@index', ['auth', 'highs']);
$router->get('/panel/manage/campaigns/add', 'ManageCampaignsController@add', ['auth', 'highs']);
$router->get('/panel/manage/campaigns/{campaign_id}/books', 'ManageCampaignsController@show', ['auth', 'highs']);

// 4.4 Contact Messages
$router->get('/panel/messages', 'ContactController@all', ['auth', 'highs']);
$router->get('/panel/messages/{message_id}', 'ContactController@show', ['auth', 'highs']);

// 5.0 Settings and User Management Routes

// 5.1 Settings Update
$router->post('/settings/update', 'SettingController@update', ['auth', 'owner']);

// 5.2 User Management
$router->post('/user/create', 'UserController@create_user', ['auth', 'owner']);
$router->post('/user/update', 'UserController@update', ['auth']);
$router->post('/user/{user_id}/to-admin', 'UserController@to_admin', ['auth', 'owner']);
$router->post('/user/{user_id}/to-user', 'UserController@to_user', ['auth', 'owner']);
$router->delete('/user/{user_id}/delete', 'UserController@delete', ['auth', 'owner']);

// 6.0 Book Management Routes

// 6.1 Book Creation and Updates
$router->post('/book/create', 'ManageBooksController@store', ['auth', 'shopkeeper']);
$router->post('/book/{book_id}/update', 'ManageBooksController@update', ['auth', 'highs']);
$router->post('/book/{shopkeeper_book_id}/update_mini', 'ManageBooksController@update_mini', ['auth', 'shopkeeper']);
$router->post('/book/{shopkeeper_book_id}/approve', 'ManageBooksController@approve', ['auth', 'highs']);
$router->post('/book/{shopkeeper_book_id}/reject', 'ManageBooksController@reject', ['auth', 'highs']);
$router->post('/book/{shopkeeper_book_id}/stop', 'ManageBooksController@stop', ['auth', 'no_user']);
$router->post('/book/{shopkeeper_book_id}/resume', 'ManageBooksController@resume', ['auth', 'no_user']);

// 7.0 Shopkeeper Routes

// 7.1 Shopkeeper Requests and Actions
$router->post('/shopkeeper/request', 'ShopkeeperController@request', ['auth', 'user']);
$router->post('/shopkeeper/{request_id}/approve', 'ShopkeeperController@approve', ['auth', 'highs']);
$router->post('/shopkeeper/{request_id}/reject', 'ShopkeeperController@reject', ['auth', 'highs']);

// 8.0 Campaign Management Routes

// 8.1 Campaign Creation and Book Management
$router->post('/campaign/start', 'ManageCampaignsController@store', ['auth', 'highs']);
$router->post('/campaign/{campaign_id}/books/{book_id}/add', 'ManageCampaignsController@add_book', ['auth', 'highs']);
$router->delete('/campaign/{campaign_id}/books/{book_id}/remove', 'ManageCampaignsController@remove_book', ['auth', 'highs']);

// 9.0 Error Handling Routes

// 9.1 Forbidden Access
$router->get('/forbidden', 'ErrorController@forbidden');
