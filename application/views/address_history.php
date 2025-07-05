<div infinite-scroll="loadTradlineList()" infinite-scroll-listen-for-event="list:filtered" infinite-scroll-distance="3">
    <ng-repeat ng-repeat="tLPartition in orderedTradeLines"> 
          <ng-include src="'tradeLinePartitionTmpl'" onload="tpartition = tLPartition"></ng-include>
</ng-repeat>
</div>