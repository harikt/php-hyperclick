<?php
namespace Hkt;

class FQCN
{
    protected $currentNamespace = '';

    public function getAllUseStatements($contents)
    {
        $tokens = token_get_all($contents);
        $shortName = $className = '';
        $useNamespace = $useFlag = $asFlag = 0;
        $result = array();

        foreach ($tokens as $token) {
            if (is_array($token)) {
                if (token_name($token[0]) == 'T_WHITESPACE') {
                    // $useNamespace = 0;
                    continue;
                }
                if (token_name($token[0]) == 'T_NAMESPACE') {
                    $useNamespace = 1;
                    continue;
                }
                if (token_name($token[0]) == 'T_CLASS') {
                    break;
                }
                if (token_name($token[0]) == 'T_USE') {
                    $useFlag = 1;
                    $useNamespace = 0;
                    continue;
                }
                if (strtolower($token[1]) == 'as') {
                    $asFlag = 1;
                    continue;
                }
                if ($useNamespace) {
                    $this->currentNamespace .= $token[1];
                }
                if ($useFlag && ! $asFlag) {
                    $className .= $token[1];
                }
                if ($asFlag) {
                    $shortName = $token[1];
                    $asFlag = 0;
                }
                // start keeping class
            } else {
                if ($useFlag && ($token == ';' || $token == ',')) {
                    $className = trim($className);
                    if (! $shortName) {
                        try {
                            $shortName = $this->getShortName($className);
                        } catch (\Exception $e) {
                            // Errored
                            continue;
                        }
                    }
                    $result[$shortName] = $className;
                    if ($token == ',') {
                        $useFlag = 1;
                    }
                    $shortName = $className = '';
                }
                /**
                 * End of namespace
                 */
                if ($token == ';' && $useNamespace == 1)
                {
                    $useNamespace = 0;
                }
            }
        }
        return $result;
    }

    public function getNamespace()
    {
        return trim($this->currentNamespace);
    }

    protected function getShortName($className)
    {
        $reflex = new \ReflectionClass($className);
        $shortName = $reflex->getShortName();
        return $shortName;
    }
}
