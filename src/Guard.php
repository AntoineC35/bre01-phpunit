<?php 
class Guard {

    public function giveAccess(Post $post, User $user) {
        if ($post->getPrivate() && in_array("ANONYMOUS", $user->getRoles())){
            throw new InvalidArgumentException("l'utilisateur ne peut pas être anonyme");
        }
        else if($post->getPrivate() && in_array("USER", $user->getRoles())) {
            $user->setRoles(["ADMIN"]);
        }
         else if($post->getPrivate() && in_array("ADMIN", $user->getRoles())) 
        {
        } 
        else if(!$post->getPrivate() && in_array("ANONYMOUS", $user->getRoles())) 
        {
            $user->setRoles(["USER"]);
        } 
        else if(!$post->getPrivate() && (in_array("ADMIN", $user->getRoles()) || in_array("USER", $user->getRoles())))
        {

        }
    }


    public function removeAccess(Post $post, User $user) {

        if ($post->getPrivate() && in_array("USER", $user->getRoles()))
        {
            $user->setRoles(["ANONYMOUS"]);
        }
        else if ($post->getPrivate() && in_array("ADMIN", $user->getRoles())) 
        {
            $user->setRoles(["USER"]);
        }
        else if (!$post->getPrivate() && in_array("ANONYMOUS", $user->getRoles())) 
        {

        }
        else if (!$post->getPrivate() && in_array("USER", $user->getRoles()))
        {
            $user->setRoles(["ANONYMOUS"]);
        }
        else if (!$post->getPrivate() && in_array("ADMIN", $user->getRoles()))
        {
            $user->setRoles(["USER"]);
        }
    }

}