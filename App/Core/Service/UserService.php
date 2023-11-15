<?php

use App\Repositories\UserRepositoryInterface;

class UserService {
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function login($email, $password) {
        $user = $this->userRepository->getByEmailAndPassword($email, $password);
        if (!$user) {
            throw new Exception("Invalid email or password");
        }
        return $user;
    }
}