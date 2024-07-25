<?php

namespace Src\Business\Customer\Persistence;

use Src\Business\Customer\Shared\CustomerDto;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function findById(int $id): ?CustomerDto
    {
        $json = file_get_contents( 'data/customers.json');
        $customerList = json_decode($json, true);

        foreach ($customerList as $customer) {
            if ($customer['id'] == $id) {
                $customerDto = new CustomerDto();
                $customerDto->setId($customer['id']);
                $customerDto->setName($customer['name']);
                $customerDto->setSince($customer['since']);
                $customerDto->setRevenue($customer['revenue']);
                return $customerDto;
            }
        }

        return null;
    }
}
