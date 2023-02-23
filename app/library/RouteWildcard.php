<?php

namespace app\library;

use app\enums\RouteWildcard as EnumsRouteWildcard;

class RouteWildcard
{

  private string $wildcardReplaced;
  private array $params = [];

  public function paramsToArray(string $uri, string $wildcard, array $aliases)
  {
    $explodeUri = explode('/', ltrim($uri, '/'));
    $explodeWildcard = explode('/', ltrim($wildcard, '/'));
    $differenceArrays = array_diff($explodeUri, $explodeWildcard);

    $aliasesIndex = 0;
    foreach ($differenceArrays as $index => $param) {
      if (!$aliases) {
        $this->params[array_values($explodeUri)[$index - 1]] = is_numeric($param) ? (int)$param : $param;
      } else {
        $this->params[$aliases[$aliasesIndex]] = is_numeric($param) ? (int)$param : $param;
        $aliasesIndex++;
      }
    }
  }

  public function replaceWildcardWithPattern(string $uriToReplace)
  {
    $this->wildcardReplaced = $uriToReplace;
    if (str_contains($this->wildcardReplaced, '(:numeric)')) {
      $this->wildcardReplaced = str_replace('(:numeric)', EnumsRouteWildcard::numeric->value, $this->wildcardReplaced);
    }

    if (str_contains($this->wildcardReplaced, '(:alpha)')) {
      $this->wildcardReplaced = str_replace('(:alpha)', EnumsRouteWildcard::alpha->value, $this->wildcardReplaced);
    }

    if (str_contains($this->wildcardReplaced, '(:numeric)')) {
      $this->wildcardReplaced = str_replace('(:any)', EnumsRouteWildcard::any->value, $this->wildcardReplaced);
    }
  }

  public function uriEqualToPattern($currentUri, $wildcardReplaced)
  {
    $wildcard = str_replace('/', '\/', ltrim($wildcardReplaced, '\/'));

    return preg_match("/^$wildcard$/", ltrim($currentUri, '/'));
  }

  public function getWildcardReplaced(): string
  {
    return $this->wildcardReplaced;
  }

  public function getParams()
  {
    return $this->params ? [...$this->params] : [];
  }
}
