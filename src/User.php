<?php
class User {
    private array $roles = ["ANONYMOUS"];
    public function __construct(private string $firstName, private string $lastName, private string $email, private string $password)
    {
        $this->ensureFirstNameIsNotEmpty($firstName);
        $this->firstName = $firstName;
        $this->ensureLastNameIsNotEmpty($lastName);
        $this->lastName = $lastName;
        $this->ensureIsValidEmail($email);
        $this->email = $email;
        $this->ensurePasswordIsValid($password);
        $this->password = $password;
    }

    private function ensureFirstNameIsNotEmpty(string $firstName): void
    {
        if (empty($firstName)) {
            throw new InvalidArgumentException("Le firstName ne peut pas être vide.");
        }
    }
    private function ensureLastNameIsNotEmpty(string $lastName): void
    {
        if (empty($lastName)) {
            throw new InvalidArgumentException("Le lastName ne peut pas être vide.");
        }
    }
    private function ensureIsValidEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid email address',
                    $email
                )
            );
        }
    }

    private function ensurePasswordIsValid(string $password): void {
            $pattern = '/^(?=.*[0-9])(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z0-9!@#$%^&*(),.?":{}|<>]{8,}$/';
            if (preg_match($pattern, $password) !== 1) {
                throw new InvalidArgumentException("Le mot de passe ne répond pas aux critères de sécurité.");
            }
    }

    private function ensureRolesIsValid(array $roles) {
        if (in_array("ANONYMOUS", $roles) && (in_array("USER", $roles) || in_array("ADMIN", $roles))) {
            throw new InvalidArgumentException("Le rôle 'ANONYMOUS' ne peut pas être présent lorsque 'USER' ou 'ADMIN' est défini.");
        } elseif (!in_array("ANONYMOUS", $roles) && !in_array("USER", $roles) && !in_array("ADMIN", $roles)) {
            throw new InvalidArgumentException("Le rôle 'ANONYMOUS' est obligatoire si 'USER' ou 'ADMIN' ne sont pas définis.");
        }
    
        return true;
    }

    public function addRole(string $newRole): array {
        if ($newRole === "USER" || $newRole === "ADMIN") {
            if (in_array($newRole, $this->roles)) {
                throw new InvalidArgumentException("$newRole is already set");
            }
    
            if (in_array("ANONYMOUS", $this->roles)) {
                $this->roles = array_diff($this->roles, ["ANONYMOUS"]);
            }
            $this->roles[] = $newRole;
            return $this->roles;
        } else {
            throw new InvalidArgumentException("$newRole is not a valid role");
        }
    
        
    }

    public function removeRole(string $role): array {
        if (in_array($role, $this->roles)) {
            $newArray = [];
            foreach ($this->roles as $item) {
                if ($item !== $role) {
                    $newArray[] = $item;
                }
            }
            $this->roles = $newArray;
            return $this->roles;
        } else {
            throw new InvalidArgumentException("$role is not in Roles");
        }
    }

    // public function removeRole(string $role): array
    // {
    //     $key = array_search($role, $this->roles);
    //     if ($key) {
    //         unset($this->roles[$key]);
    //     }
    //     return $this->roles;
    // }
    
    

    public function getRoles()
    {
        return $this->roles;
    }


    public function setRoles($roles)
    {
        if ($this->ensureRolesIsValid($roles))
        $this->roles = $roles;

        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }


    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }


    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

 
    public function getEmail()
    {
        return $this->email;
    }

 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
 
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
}