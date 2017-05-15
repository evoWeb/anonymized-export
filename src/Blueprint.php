<?php
namespace Evoweb\AnonymizedExport;

class Blueprint extends \Arrilot\DataAnonymization\Blueprint
{
    /**
     * Set how data should be replaced.
     *
     * @param callable|string $callback
     *
     * @return void
     */
    public function replaceWith($callback)
    {
        $this->currentColumn['replace'] = $callback;

        $this->columns[$this->currentColumn['name']] = $this->currentColumn;
    }
}
