<?php

/*
 * This file is part of the Superdesk Web Publisher Content Bundle.
 *
 * Copyright 2016 Sourcefabric z.ú. and contributors.
 *
 * For the full copyright and license information, please see the
 * AUTHORS and LICENSE files distributed with this source code.
 *
 * @copyright 2016 Sourcefabric z.ú
 * @license http://www.superdesk.org/license
 */

namespace SWP\Bundle\ContentBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Cmf\Bundle\RoutingBundle\Model\Route as BaseRoute;

class Route extends BaseRoute implements RouteInterface
{
    use RouteTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var Collection
     */
    protected $articles;

    /**
     * @var RouteInterface
     */
    protected $root;

    /**
     * @var RouteInterface
     */
    protected $parent;

    /**
     * @var Collection|RouteInterface[]
     */
    protected $children;

    /**
     * @var int
     */
    protected $lft;

    /**
     * @var int
     */
    protected $rgt;

    /**
     * @var int
     */
    protected $level;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->children = new ArrayCollection();

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * {@inheritdoc}
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return parent::getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteName()
    {
        return $this->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function isRoot(): bool
    {
        return null === $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoot(): RouteInterface
    {
        return $this->root;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(RouteInterface $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * @return Collection|RouteInterface[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function hasChild(RouteInterface $route): bool
    {
        return $this->children->contains($route);
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(RouteInterface $route)
    {
        if (!$this->hasChild($route)) {
            $route->setParent($this);
            $this->children->add($route);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeChild(RouteInterface $route)
    {
        if ($this->hasChild($route)) {
            $route->setParent(null);
            $this->children->removeElement($route);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getLeft(): int
    {
        return $this->lft;
    }

    /**
     * {@inheritdoc}
     */
    public function setLeft(int $left)
    {
        $this->lft = $left;
    }

    /**
     * {@inheritdoc}
     */
    public function getRight(): int
    {
        return $this->rgt;
    }

    /**
     * @param int $right
     */
    public function setRight(int $right)
    {
        $this->rgt = $right;
    }

    /**
     * {@inheritdoc}
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * {@inheritdoc}
     */
    public function setLevel(int $level)
    {
        $this->level = $level;
    }

    /**
     * {@inheritdoc}
     */
    public function getParentId()
    {
        if (null !== $this->parent) {
            return (int) $this->parent->getId();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRootId()
    {
        if (null !== $this->root) {
            return (int) $this->root->getId();
        }
    }
}
