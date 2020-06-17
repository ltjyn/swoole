<?php

namespace Think\Core\Route\Annotation\Parser;

/**
 * Class ControllerParser
 *
 * @AnnotationParser(Controller::class)
 *
 * @since 2.0
 */
class ControllerParser extends Parser
{
    /**
     * @param int        $type
     * @param Controller $annotation
     *
     * @return array
     * @throws HttpServerException
     */
    public function parse(int $type, $annotation): array
    {
        if ($type !== self::TYPE_CLASS) {
            throw new HttpServerException('`@Controller` must be defined by class!');
        }

        // add route prefix for controller
        RouteRegister::addPrefix($this->className, $annotation->getPrefix());

        return [$this->className, $this->className, Bean::SINGLETON, ''];
    }
}