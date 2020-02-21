<?php

namespace App;

use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Traits\UsesSystemConnection;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;

/**
 * @property Website  website
 * @property Hostname hostname
 * @property Staff    admin
 */
class Tenant {

    use UsesSystemConnection;

    public function __construct(Website $website = null, Hostname $hostname = null, Staff $admin = null)
    {
        $this->website = $website;
        $this->hostname = $hostname;
        $this->admin = $admin;
    }

    public static function delete($name)
    {
        $baseUrl = env('APP_URL_BASE');
        $name = "{$name}.{$baseUrl}";
        if ($tenant = Hostname::where('fqdn', $name)->firstOrFail())
        {
            app(HostnameRepository::class)->delete($tenant, true);
            app(WebsiteRepository::class)->delete($tenant->website, true);

            return "Tenant {$name} successfully deleted.";
        }
    }

    public static function deleteByFqdn($fqdn)
    {
        if ($tenant = Hostname::where('fqdn', $fqdn)->firstOrFail())
        {
            app(HostnameRepository::class)->delete($tenant, true);
            app(WebsiteRepository::class)->delete($tenant->website, true);

            return "Tenant {$fqdn} successfully deleted.";
        }
    }

    public static function registerTenant($tenantSlug) : Tenant
    {
        // Make a default user of the host and the tenant.
        User::create([
            'name'              => "Tenant",
            'email'             => "tenant@livewire.test",
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);


        $tenantSlug = strtolower($tenantSlug);
        $website = new Website;

        $website->uuid = env('DB_DATABASE') . ".{$tenantSlug}";
        app(WebsiteRepository::class)->create($website);

        // associate the website with a hostname
        $hostname = new Hostname;
        $baseUrl = env('APP_URL_BASE');
        $hostname->fqdn = "{$tenantSlug}.{$baseUrl}";
        app(HostnameRepository::class)->attach($hostname, $website);

        // Make a default user of the tenant.
        $admin = static::makeAdmin();

        // make hostname current
        app(Environment::class)->tenant($hostname->website);

        return new Tenant($website, $hostname, $admin);
    }

    private static function makeAdmin() : Staff
    {
        $admin = Staff::create([
            'name'              => "Tenant",
            'email'             => "tenant@livewire.test",
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $admin->guard_name = 'employee';

        return $admin;
    }

    public static function tenantExists($name)
    {
        $name = $name . '.' . env('APP_URL_BASE');

        return Hostname::where('fqdn', $name)->exists();
    }
}
