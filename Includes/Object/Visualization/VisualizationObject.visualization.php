<?php

namespace Visualization;

/**
 * VisualizationObject
 */
class VisualizationObject
{
    /**
     * @var object $is VisualiaztionObjectIs
     */
    public VisualizationObjectIs $is;

    /**
     * @var object $get VisualiaztionObjectGet
     */
    public VisualizationObjectGet $get;

    /**
     * @var object $set VisualiaztionObjectSet
     */
    public VisualizationObjectSet $set;

    /**
     * Sets object
     * 
     * @param array $object
     * 
     * @return void
     */
    public function __construct( array $object )
    {
        $this->is = new VisualizationObjectIs($object);
        $this->get = new VisualizationObjectGet($object);
        $this->set = new VisualizationObjectSet($object);
    }

    /**
     * Returns edited object
     *
     * @return array
     */
    public function getObject()
    {
        return $this->set->delete->object;
    }
}