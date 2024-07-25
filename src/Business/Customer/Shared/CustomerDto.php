<?php

namespace Src\Business\Customer\Shared;

class CustomerDto
{
    public int $id;
    public string $name;
    public string $since;
    public float $revenue;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setSince(string $since): void
    {
        $this->since = $since;
    }

    public function getSince(): string
    {
        return $this->since;
    }

    public function setRevenue(float $revenue): void
    {
        $this->revenue = $revenue;
    }

    public function getRevenue(): float
    {
        return $this->revenue;
    }
}
