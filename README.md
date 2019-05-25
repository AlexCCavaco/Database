# Database
A Database Query Builder for PHP

There are four classes from where to start building:
**DBDelete**, **DBInsert**, **DBSelect** and **DBUpdate**

These are assigned to equivalent MySQL queries.

## Installation

```
  composer require alexccavaco/database
```

## Examples

Select Query:
```
  $r=DBSelect::from('table')
    ->select('*')
    ->where('column1 = ?', $data1)
    ->where('column2 = ?', $data2)
    ->orderBy('name')
    ->run($db);

  $r->fetch(\PDO::FETCH_ASSOC);
```

Delete Query:
```
  $r=DBUpdate::table('table')
    ->set('column','?',$param)
    ->setAll(['column'=>$param,'anotherCol'=>$param2])
    ->where('column = ?','data')
    ->run($db);

  $r->fetch(\PDO::FETCH_ASSOC);
```

Insert Query:
```
  $r=DBInsert::into('table')
    ->value('column1',$param1)
    ->value('column2',$param2,true) //The third parameter if true automatically sets On Duplicate Update
    ->values(['column'=>$param])
    ->run($db);

  $r->fetch(\PDO::FETCH_ASSOC);
```

Delete Query:
```
  $r=DBDelete::from('table')
    ->where('column = ?','data')
    ->limit(2)
    ->run($db);

  $r->fetch(\PDO::FETCH_ASSOC);
```

Complex Queries can be created, using joins, having... but these are just a few examples.

## Database Class

With the package comes a Database Class.
This class sets some attributes by default (such as the use of exceptions for errors and emulate prepares)
and its constructor eases the setting of charsets and timezones for mysql.

Two functions come with it:
- prepRun - Eases the preparation of statements, preparing and executing them before returning
- logStatement - Receives a PSR Logger and a log type to log every query and parameters (for debugging)

**This class is completely optional.**
