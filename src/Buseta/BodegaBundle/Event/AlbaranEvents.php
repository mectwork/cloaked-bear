<?php

namespace Buseta\BodegaBundle\Event;


final class AlbaranEvents
{
    const PRE_CREATE = 'buseta.bodega.albaran.pre_create';

    const POS_CREATE = 'buseta.bodega.albaran.pos_create';

    const PRE_PROCESS = 'buseta.bodega.albaran.pre_process';

    const POS_PROCESS = 'buseta.bodega.albaran.pos_process';

    const PRE_COMPLETE = 'buseta.bodega.albaran.pre_complete';

    const POS_COMPLETE = 'buseta.bodega.albaran.pos_complete';
}
