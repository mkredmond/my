<?php

namespace App\Auth;

class Ldap
{
    /**
     * FQDN for LDAP server
     * @var string
     */
    protected $hostname;

    /**
     * ldap:// or ldaps://
     * @var string
     */
    protected $protocol;

    /**
     * Port number
     * @var integer
     */
    protected $port;

    /**
     * Constructed url for accessing ldap
     * @var string
     */
    protected $ldap_url;

    /**
     * Ldap connection object
     * @var Object
     */
    protected $ldap;

    /**
     * Filter for querying ldap directory
     * @var string
     */
    protected $filter;

    /**
     * Username of user attempting login
     * @var string
     */
    private $bind_username;

    /**
     * Password of user attempting login
     * @var string
     */
    private $bind_password;

    /**
     * Generate basic information for ldap connection string
     * @param string $hostname
     * @param string $protocol
     * @param string $port
     */
    public function __construct($hostname, $protocol = "ldap", $port = "389")
    {
        $this->hostname = $hostname;

        $this->protocol = $protocol;

        $this->port = $port;

        $this->ldap_url = $this->protocol . "://" . $this->hostname . ":" . $this->port;

    }

    /**
     * Sets ldap property to an ldap connection object
     * @return boolean
     */
    public function openConnection()
    {

        if (!$this->ldap = @ldap_connect($this->ldap_url)) {
            throw new \Exception('Could not connect to LDAP server.');
        }

        $this->set_ldap_options();

        return true;
    }

    /**
     * Attempt to bind user's credentials against ldap
     * @param  array  $credentials - username/password
     * @return boolean
     */
    public function attemptLogin(array $credentials)
    {
        $this->bind_username = "ACADEMIA\\" . $credentials['username'];
        $this->bind_password = $credentials['password'];
        $this->filter        = "(sAMAccountName=" . $credentials['username'] . ")";

        return (bool) @ldap_bind($this->ldap, $this->bind_username, $this->bind_password);
    }

    /**
     * Retrieves user's information from ldap
     * @return Array
     */
    public function getUserInfo()
    {
        $result = @ldap_search($this->ldap, "ou=Accounts,dc=academia,dc=sjfc,dc=edu", $this->filter);

        @ldap_sort($this->ldap, $result, "sn");
        $info = @ldap_get_entries($this->ldap, $result);

        return array(
            'dn'        => $info[0]['dn'],
            'givenname' => $info[0]['givenname'][0],
            'surname'   => $info[0]['sn'][0],
            'title'     => $info[0]['title'][0],
            'email'     => $info[0]['mail'][0],
        );
    }

    /**
     * Close ldap connection
     * @return void
     */
    public function closeConnection()
    {
        ldap_close($this->ldap);
    }

    /**
     * Configure ldap options
     * @return  void
     */
    protected function set_ldap_options()
    {
        ldap_set_option($this->ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->ldap, LDAP_OPT_REFERRALS, 0);
    }
}
