# Upgrading from v2.4 to v2.5

* To address the question raised in the previous version, now the original extension '.csv' is retained
  even if the mime type is guessed as 'text/plain'.

# Upgrading from v2.3 to v2.4

* To address a security question, the original extension of the uploaded file is not preserved anymore.
  Instead, it is replaced by the extension of the matching mime type. This could cause a different
  behaviour only if you use some non-standard extension, otherwise it should not change anything.

# Upgrading from v2.1 to v2.2

* The signature of `StorageInterface::resolveStream` method was changed. The $fieldName parameter is now nullable. 
* the `AdapterInterface` no longer requires `getObjectFromArgs` method.
* the `AdapterInterface::recomputeChangeSet()` accepts `Doctrine\Persistence\Event\LifecycleEventArgs` as argument.

# Upgrading from v2.0 to v2.1

* the internal class `FilenameUtils` has been removed.

# Upgrading from v1 to v2.0

* every class marked as `@final` is now final
* all properties are now fully type-hinted
* all methods arguments are now fully type-hinted
* all methods have now return types
* all constructors now use property promotion
* all deprecated features were removed
* the new default type for mapping is "attribute". You can still use annotations, but you need an explicit definition (set "annotation" as value for "vich_uploader.metadata.type" config key)
* the service "vich_uploader.current_date_time_helper" has been removed. The `DateTimeHelper` interface has been
  removed as well.
