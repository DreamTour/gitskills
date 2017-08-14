function add(obj){
		this.btn = $(obj.btnSelector);
		this.target = $(obj.targetSelector);
		this.addList();
	}
	add.prototype = {
		addList:function(){
			self = this;
			this.btn.click(function(){
				self.target.after('<div class="pe-info-compress clearfix"><h2 class="fl">招聘平面设计师</h2><div class="fr"><a href="javascript:;" class="pe-edit-btn">编辑</a><a href="javascript:;" class="pe-delete-btn">删除</a><a href="javascript:;" class="pe-preview-btn">预览</a></div></div>');	
			})
		}	
	}
	new add({
		btnSelector:'[name=supplyForm] .peSave-btn',	
		targetSelector: '#supply'
	});
	new add({
		btnSelector:'[name=demandForm] .peSave-btn',	
		targetSelector: '#demand'
	})          // JavaScript Document
	
	
	<script>
$(document).ready(function(){
	var Form = document.userForm;
	/*//根据省份获取下属城市下拉菜单
	Form.province.onchange = function(){
		Form.area.innerHTML = "<option value=''>--区县--</option>";
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:this.value},function(data){
			Form.city.innerHTML = data.city;
		},"json");
	}
	//根据省份和城市获取下属区域下拉菜单
	Form.city.onchange = function(){
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:Form.province.value,CityPostArea:this.value},function(data){
			Form.area.innerHTML = data.area;
		},"json");
	}
	//劳务供给根据主项目返回子项目
	var supplyForm = document.supplyForm;
	supplyForm.supplyColumn.onchange = function(){
		$.post("<?php echo root."library/usdata.php";?>",{supplyColumn:this.value},function(data){
			supplyForm.supplyColumnChild.innerHTML = data.ColumnChild;
		},"json")	
	}
	//劳务需求根据主项目返回子项目
	var demandForm = document.demandForm;
	demandForm.demandColumn.onchange = function(){
		$.post("<?php echo root."library/usdata.php";?>",{demandColumn:this.value},function(data){
			demandForm.demandColumnChild.innerHTML = data.ColumnChild;
		},"json")	
	}*/
	//addDelete
	function addDelete(obj){
		this.addBtn = $(obj.addBtnSelector);
		this.target = $(obj.targetSelector);
		this.deleteBtn = obj.deleteBtnSelector;
	}
	addDelete.prototype = {
		addSupplyList:function(url,params,fn){
			var self = this;
			this.addBtn.click(function(){
				$.ajax({
					url:url,
					type:"POST",
					dataType: "json",
					data:params.serialize(),
					success:function(data){
						if(data.warn == 2){
							if(typeof fn == 'function'){
								fn(self,data);
							}
						}else{
							warn(data.warn);
						}
					},error: function(){
						warn('服务器拒绝了你的请求');
					}
				})
				
				$('.pe-info-compress').first().css({'display':'none'}).fadeIn(1000);
			})
		},
		deleteSupplyList:function(type){
			var self = this;
			$(document).on('click','['+this.deleteBtn+']',function(e){
				var _this =$(this);
				var DeleteId = _this.attr(self.deleteBtn);
				if(type == 'supply'){
					var d = {DeleteId:DeleteId};
				}else if(type == 'demand'){
					var d = {DeleteDemandId:DeleteId};
				}
				if(confirm("确定要删除吗？")){
					$.getJSON('<?php echo root."library/usdata.php";?>',d,function(data){
						if(data.warn == 2){
							var tar = _this.parents('.pe-info-compress');
							tar.fadeOut(function(){
								tar.remove();
							});
						}else{
							warn(data.warn);
						}
					})
				}
				
			});

		}	
	}
	var supply = new addDelete({
		addBtnSelector:'[name=supplyForm] .peSave-btn',	
		targetSelector: '#supply',
		deleteBtnSelector:'data_del_id'
	});
	/*supply.addSupplyList("<?php echo root."library/usdata.php";?>",$('[name="supplyForm"]'),function(self,data){
		self.target.after('<div class="pe-info-compress clearfix"><h2 class="fl">'+data.title+'</h2><div class="fr"><a href="javascript:;" class="pe-edit-btn" data_edit_id="'+data.id+'">编辑</a><a href="javascript:;" class="pe-delete-btn" data_del_id="'+data.id+'">删除</a><a href="javascript:;" class="pe-preview-btn">预览</a></div></div>');	
	});*/
	supply.deleteSupplyList('supply');
	var demand = new addDelete({
		addBtnSelector:'[name=demandForm] .peSave-btn',	
		targetSelector: '#demand',
		deleteBtnSelector:'data_del_id2'
	});
	/*demand.addSupplyList("<?php echo root."library/usdata.php";?>",$('[name="demandForm"]'),function(self,data){
		self.target.after('<div class="pe-info-compress clearfix"><h2 class="fl">'+data.title+'</h2><div class="fr"><a href="javascript:;" class="pe-edit-btn" data_edit_id2="'+data.id+'">编辑</a><a href="javascript:;" class="pe-delete-btn" data_del_id2="'+data.id+'">删除</a><a href="javascript:;" class="pe-preview-btn">预览</a></div></div>');	
	});*/
	demand.deleteSupplyList('demand');
	function Anchor(object){
		this.btn = $(object.btn);
		this.target = $(object.target);
		this.Scroll();	
	}
	Anchor.prototype={
		Scroll:function(){
			var self = this;
			this.btn.bind('click',function(){
				$("html,body").animate({scrollTop:self.target.offset().top},300)	
			})
		}	
	}
	new Anchor({
		btn:".userAnchor",
		target:"#userAnchor"	
	})
	new Anchor({
		btn:".supplyAnchor",
		target:"#supplyAnchor"	
	})
	new Anchor({
		btn:".demandAnchor",
		target:"#demandAnchor"	
	})
	
	function ChoiceTime(object){
		this.btn = $(object.btn);
		this.table = $(object.table);
		this.Hook = object.Hook;
		this.TimeTableCheckBox = $(object.TimeTableCheckBox);
		this.ChoiceTab();
		this.HookTab();	
	}
	ChoiceTime.prototype = {
		ChoiceTab:function(){
			var self = this;
			this.btn.click(function(){
				if($(this).val() == '时间表'){
					self.table.fadeIn();
				}else{
					self.table.fadeOut();	
				}
			})
		},
		HookTab:function(){
			var self = this;
			$(document).on('click',this.Hook,function(){
				$(this).toggleClass("current1");
				var TimeTable = $(this).attr('TimeTable');
				if($(this).hasClass('current1')){
					self.TimeTableCheckBox.each(function(index, element) {
						if($(this).val() == TimeTable ){
							$(this).prop('checked',true);	
						}
                	});	
				}else{
					self.TimeTableCheckBox.each(function(index, element) {
						if($(this).val() == TimeTable){
							$(this).removeAttr('checked');	
						}
                	});	
				}
			});	
		}	
	}
	new ChoiceTime({
		btn:'[name="supplyWorkingHours"]',
		table:"#timeBox",
		Hook:".time-current",
		TimeTableCheckBox:".TimeTableCheckBox"	
	})
});
