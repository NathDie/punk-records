<?php

namespace App\Trait;

use Doctrine\ORM\Mapping as ORM;

trait ActivableTrait
{
    #[ORM\Column]
    private ?bool $active = false;

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }
}
