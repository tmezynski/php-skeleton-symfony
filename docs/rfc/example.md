# CosmosDB replacement with PostgreSQL

* Status: closed
* Authors: <redacted>
* Date: 2019-06-10

Technical Story: N/A

## Context and Problem Statement

CosmosDB turned out not to be production ready. It has a very low insert rate (effectively 50 operations/s),
and the driver breaks regularly. Attempts to speed this up resulted in unacceptably high costs. We also often lack
the transactional support and ability to use any embedded nor containerized version for local tests.
Last but not least: MS does not provide real support for CosmoDB - after reporting issues with production
which they have confirmed, no fix or workaround was provided for more than 4 weeks.

A sample project presenting CosmoDB limitations is available [here](https://github.com/jakubnabrdalik/cosmodb-mongo-issue)
A detailed explanation of the research, can be found [here](https://github.com/jakubnabrdalik/cosmodb-mongo-issue/blob/master/src/main/java/com/vattenfall/reactivemongodb/ReactiveMongodbApplication.java)

## RFC Drivers

* performance
* costs
* testability
* features
* security
* maintainability

## Considered Options

* CosmosDB
* MongoDB Atlas (as a Service)
* Mongo on AKS
* PostreSQL as a Service

## Pros and Cons of the Options

### CosmosDB

* Pros
    * hosted on our Azure subscription
    * available as a service
    * we already use it in production

* Cons
    * slow
        * the unit of declared throughput is called **request units per second** and is confusing
        * it is impossible to map RU/s to actual network throughput, and only MS controls the algorithm calculating the number of RU per operations
        * effective insert rate is **50 operations/s**
        * even with all the tweaks to increase the RU/s, the driver breaks regularly with an eror "The MAC signature found in the HTTP request is not the same as the computed signature. Server used following string to sign...".
    * cannot be used for tests:
        * differences between CosmosDB and MongoDB cause errors that cannot be discovered before going live
    * expensive
        * [Cost calculations](https://azure.microsoft.com/pl-pl/pricing/details/cosmos-db/) are based on declared throughput (RU/s - request units per second) and used storage
        * The least usable collection containing 1GB of data requiring 4000RU/s costs 195 EUR
    * not-responsive in case of big queries
        * as an example, having a collection of CDRs consuming 2GB of data and having 8000RU/s (389 EUR/month) we are unable
          to download two reports in parallel as the first one is using all of the available throughput
    * no production ready support
        * All production issues have been confirmed by Microsoft but no fix or workaround was provided for the next 4+ weeks. This means that in practice there is no SLA for CosmosDB

### MongoDB Atlas (as a Service)

* Pros
    * real MongoDB
    * hosted by authors of MongoDB
    * available as a service

* Cons
    * hosted outside of our subscription

### MongoDB on AKS

* Pros
    * hosted entirely under our control

* Cons
    * not available as a service
    * requires manual operations, support, training
    * cannot be delivered as quick as other solution (lack of experience in this area)

### PostgreSQL

* Pros
    * available as a service
    * relatively cheap
        * As an example a database with one virtual CPU 2.4GHz and 5GB of data costs around 30 EUR/month and is able to easily serve much bigger traffic than CosmosDB
    * fast
        * Effective throughput is incomparably higher then in CosmosDB
    * supports document (json) handling
        * field indexes available
        * field update available
    * transaction support

* Cons
    * lack of fully reactive driver at the moment

## Outcome suggestion

Having aforementioned options, we suggest choosing: PostgreSQL as a service, because of the cost reduction and effectiveness that it can provide comparing to CosmosDB.

As we cannot set up any service outside of our subscription - Atlas is out of question. Setting up and maintaining MongoDB by ourselves would be too expensive.

### Positive Consequences

* Higher effective throughput
* Transaction support provided
* Cost reduction due to much better pricing offer compared to current solution (CosmosDB)

### Negative Consequences

* There will be a considerable cost of migrating existing collections from Cosmos DB
    * DB configuration
    * Schema definition and schema management tool configuration
    * Data migration
    * Integration tests to be rewritten


## Links

* [A sample project presenting CosmoDB limitations] (https://github.com/jakubnabrdalik/cosmodb-mongo-issue)
* [A detailed explanation of the research, can be found] (https://github.com/jakubnabrdalik/cosmodb-mongo-issue/blob/master/src/main/java/com/vattenfall/reactivemongodb/ReactiveMongodbApplication.java)

## Opened questions

* Have you met any other issues regarding CosmosDB or PostgreSQL usage?
