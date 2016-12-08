<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Schema;
use Uuid;
use Sentinel;
use App\Models\UserInfo;
use App\Models\User;
use Illuminate\Console\Command;

/**
 * Class AppCommand.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class AppCommand extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * Holds the user information.
	 *
	 * @var array
	 */
	protected $userData = array(
		'first_name' => null,
		'last_name' => null,
		'username' => null,
		'slug' => null,
		'email' => null,
		'password' => null,
		'uuid' => null,
	);

	protected $userInfoData = array(
		'user_id' => null,
		'display_name' => null
	);

	/**
	 * Execute the console command.
	 */
	public function handle()
	{

		Schema::dropIfExists('activations');
		Schema::dropIfExists('activities');
		Schema::dropIfExists('alerts');
		Schema::dropIfExists('articles');
		Schema::dropIfExists('blog_comments');
		Schema::dropIfExists('brands');
		Schema::dropIfExists('cart');
		Schema::dropIfExists('categories');
		Schema::dropIfExists('combos');
		Schema::dropIfExists('coupons');
		Schema::dropIfExists('dealers');
		Schema::dropIfExists('faqs');
		Schema::dropIfExists('form_posts');
		Schema::dropIfExists('invoice_items');
		Schema::dropIfExists('invoices');
		Schema::dropIfExists('keys');
		Schema::dropIfExists('locations');
		Schema::dropIfExists('logs');
		Schema::dropIfExists('maillist');
		Schema::dropIfExists('menus');
		Schema::dropIfExists('messages');
		Schema::dropIfExists('migrations');
		Schema::dropIfExists('news');
		Schema::dropIfExists('option_values');
		Schema::dropIfExists('options');
		Schema::dropIfExists('orders');
		Schema::dropIfExists('pages');
		Schema::dropIfExists('payment');
		Schema::dropIfExists('persistences');
		Schema::dropIfExists('photo_galleries');
		Schema::dropIfExists('photos');
		Schema::dropIfExists('product_album');
		Schema::dropIfExists('product_features');
		Schema::dropIfExists('product_requirements');
		Schema::dropIfExists('product_variants');
		Schema::dropIfExists('products');
		Schema::dropIfExists('projects');
		Schema::dropIfExists('promos');
		Schema::dropIfExists('ratings');
		Schema::dropIfExists('reminders');
		Schema::dropIfExists('reviews');
		Schema::dropIfExists('roles');
		Schema::dropIfExists('sections');
		Schema::dropIfExists('settings');
		Schema::dropIfExists('sliders');
		Schema::dropIfExists('sub_categories');
		Schema::dropIfExists('tags');
		Schema::dropIfExists('throttle');
		Schema::dropIfExists('userinfo');
		Schema::dropIfExists('users');
		Schema::dropIfExists('videos');

		Schema::dropIfExists('articles_tags');
		Schema::dropIfExists('box_shippingmethod');
		Schema::dropIfExists('category_product');
		Schema::dropIfExists('combo_price');
		Schema::dropIfExists('dealer_location');
		Schema::dropIfExists('dealer_user');
		Schema::dropIfExists('location_shippingmethod');
		Schema::dropIfExists('location_user');
		Schema::dropIfExists('order_product');
		Schema::dropIfExists('product_shippingmethod');
		Schema::dropIfExists('role_users');
		Schema::dropIfExists('taggable_taggables');
		Schema::dropIfExists('taggable_tags');

		$this->comment('=====================================');
		$this->comment('');
		$this->info('  Step: 1');
		$this->comment('');
		$this->info('    Please follow the following');
		$this->info('    instructions to create your');
		$this->info('    default user.');
		$this->comment('');
		$this->comment('-------------------------------------');
		$this->comment('');

		// Let's ask the user some questions, shall we?
		$this->askUserFirstName();
		$this->askUserLastName();
		$this->askUserEmail();
		$this->askUserPassword();

		$this->comment('');
		$this->comment('');
		$this->comment('=====================================');
		$this->comment('');
		$this->info('  Step: 2');
		$this->comment('');
		$this->info('    Preparing your Application');
		$this->comment('');
		$this->comment('-------------------------------------');
		$this->comment('');

		// Generate the Application Encryption key
		$this->call('key:generate');

		// Create the migrations table
		$this->call('migrate:install');

		// Run the Migrations
		$this->call('migrate');

		// Create the default user and default groups.
		$this->sentinelRunner();

		// Seed the tables with dummy data
		$this->call('db:seed');
	}

	/**
	 * Asks the user for the first name.
	 */
	protected function askUserFirstName()
	{
		do {
			// Ask the user to input the first name
			//$first_name = $this->ask('Please enter your first name: ');
			$first_name = 'phillip';
			// Check if the first name is valid
			if ($first_name == '') {
				// Return an error message
				$this->error('Your first name is invalid. Please try again.');
			}

			// Store the user first name
			$this->userData['first_name'] = $first_name;
		} while (!$first_name);
	}

	/**
	 * Asks the user for the last name.
	 */
	protected function askUserLastName()
	{
		do {
			// Ask the user to input the last name
			//  $last_name = $this->ask('Please enter your last name: ');
			$last_name = 'madsen';
			// Check if the last name is valid.
			if ($last_name == '') {
				// Return an error message
				$this->error('Your last name is invalid. Please try again.');
			}

			// Store the user last name
			$this->userData['last_name'] = $last_name;
		} while (!$last_name);
	}

	/**
	 * Asks the user for the user email address.
	 */
	protected function askUserEmail()
	{
		do {
			// Ask the user to input the email address
			//  $email = $this->ask('Please enter your user email: ');
			$email = 'pmadsen2013@gmail.com';
			// Check if email is valid
			if ($email == '') {
				// Return an error message
				$this->error('Email is invalid. Please try again.');
			}

			// Store the email address
			$this->userData['email'] = $email;
		} while (!$email);
	}

	/**
	 * Asks the user for the user password.
	 */
	protected function askUserPassword()
	{
		do {
			// Ask the user to input the user password
			// $password = $this->ask('Please enter your user password: ');
			$password = 'mad15696';
			// Check if email is valid
			if ($password == '') {
				// Return an error message
				$this->error('Password is invalid. Please try again.');
			}

			//$username = 'phillipmadsen';
			// Store the password
			$this->userData['isAdmin'] = 1;


			$this->userData['username'] =  $this->userData['first_name'] . " " . $this->userData['last_name'];
			$this->userData['slug'] = str_slug($this->userData['first_name'] . " " . $this->userData['last_name'], '-');
			$this->userData['uuid'] = \Uuid::generate(3, $this->userData['first_name'] . $this->userData['last_name'], Uuid::NS_DNS);


			// UserInfo::create(["user_id" => $user->id, "photo" => "/content/".$user->username."/photos/profile.png"]);
			$this->userData['password'] = $password;
		} while (!$password);
	}

	/**
	 * Runs all the necessary Sentry commands.
	 */
	protected function sentinelRunner()
	{
		// Create the default groups
		$this->sentinelCreateDefaultGroups();

		// Create the user
		$this->sentinelCreateUser();

		$this->sentinelCreateRobUser();

		// Create dummy user
		$this->sentinelCreateDummyUser();
	}

	/**
	 * Creates the default groups.
	 */
	protected function sentinelCreateDefaultGroups()
	{
		// Create the admin group
		$this->role = Sentinel::getRoleRepository()->createModel()->create([
			'name' => 'SuperAdmin',
			'slug' => 'superadmin',
		]);

		// Show the success message.
		$this->comment('');
		$this->info('Admin group created successfully.');
	}


	/**
	 * Create the user and associates the admin group to that user.
	 */
	protected function sentinelCreateUser()
	{
		// Prepare the user data array.
		$data = array_merge($this->userData, array(
			'activated' => 1,
			'referral_id' => null,
			'is_online' => 0,
			'referred_by' => null,
			'last_login' => Carbon::now(),
			'created_at' => Carbon::now(),
			'updated_at' =>  Carbon::now()

		));

		$user = Sentinel::registerAndActivate($data);

		UserInfo::create([
			"user_id" => $user->id,
			"display_name" => $this->userData['first_name'] . " " . $this->userData['last_name'],
			"is_active" => 1,
			"website" => "www.grace.com"
		]);

		$this->role->users()->attach($user);


		// Show the success message
		$this->comment('');
		$this->info('Your user was created successfully.');
	}

	/**
	 * Create a dummy user.
	 */
	protected function sentinelCreateRobUser()
	{
		$user = Sentinel::registerAndActivate(array(
			'first_name' => 'Rob',
			'last_name' => 'Modi',
			'username' => 'Admin',
			'slug'   => str_slug(('rob modi'), '-'),
			'isAdmin' => 1,
			'email' => 'rob@devsimplify.com',
			'password' => 'admin',
			'activated' => 1,
			'uuid' => \Uuid::generate(3,'robmodi', Uuid::NS_DNS),
			'referral_id' => null,
			'is_online' => 0,
			'referred_by' => null,
			'last_login' => Carbon::now(),
			'created_at' => Carbon::now(),
			'updated_at' =>  Carbon::now()
		));

		$userInfo = UserInfo::create([
			"user_id" => $user->id,
			"display_name" => "Rob" . " " ."Modi",
			"is_active" => 1,
			"website" => "www.grace.com"
		]);

		$this->role->users()->attach($user);

		// Show the success message
		$this->comment('');
		$this->info('Robs user was created successfully.');
		$this->comment('');
	}

	/**
	 * Create a dummy user.
	 */
	protected function sentinelCreateDummyUser()
	{
		$user = Sentinel::registerAndActivate(array(
			'first_name' => 'Super',
			'last_name' => 'Admin',
			'username' => 'Super Admin',
			'slug'   => str_slug(('super admin'), '-'),
			'isAdmin' => 1,
			'email' => 'admin@admin.com',
			'password' => 'admin',
			'activated' => 1,
			'remember_token' => '',
			'permissions' => '',
			'uuid' => \Uuid::generate(3,'superadmin', Uuid::NS_DNS),
			'referral_id' => null,
			'is_online' => 0,
			'referred_by' => null,
			'last_login' => Carbon::now(),
			'created_at' => Carbon::now(),
			'updated_at' =>  Carbon::now()

		));

		$this->role->users()->attach($user);

		// Show the success message
		$this->comment('');
		$this->info('Admin user was created successfully.');
		$this->comment('');
	}
}
